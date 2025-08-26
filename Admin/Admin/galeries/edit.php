<?php
include '../Components/base_admin.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID manquant.");
}


$stmt = $pdo->prepare("SELECT * FROM galeries WHERE id = ?");
$stmt->execute([$id]);
$galerie = $stmt->fetch();

if (!$galerie) {
    die("Galerie introuvable.");
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre       = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $photo       = $galerie['photo'];

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            // Nom sécurisé
            $safeTitre = preg_replace('/[^A-Za-z0-9_\-]/', '_', $titre);
            $safeDate  = date("Ymd_His");
            $newName   = $safeTitre . '_' . $safeDate . '.' . $ext;

            $uploadDir = __DIR__ . "/../assets/img/galeries/";
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

            $uploadPath = $uploadDir . $newName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                
                if (!empty($photo) && file_exists($uploadDir . $photo)) {
                    unlink($uploadDir . $photo);
                }
                $photo = $newName;
            } else {
                $message = "❌ Erreur lors du téléchargement de l'image.";
            }
        } else {
            $message = "❌ Format non autorisé. Formats valides : JPG, JPEG, PNG, WEBP.";
        }
    }

    if (empty($message)) {
        try {
            $stmt = $pdo->prepare("UPDATE galeries SET titre = ?, description = ?, photo = ? WHERE id = ?");
            $stmt->execute([$titre, $description, $photo, $id]);
            $message = "✅ Galerie mise à jour avec succès.";

           
            $stmt = $pdo->prepare("SELECT * FROM galeries WHERE id = ?");
            $stmt->execute([$id]);
            $galerie = $stmt->fetch();
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-3">Modifier la Galerie</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($galerie['titre'] ?? '') ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($galerie['description'] ?? '') ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo actuelle</label><br>
            <?php if (!empty($galerie['photo']) && file_exists(__DIR__ . "/../assets/img/galeries/" . $galerie['photo'])): ?>
                <img src="../assets/img/galeries/<?= htmlspecialchars($galerie['photo']) ?>" alt="photo" style="max-width: 150px;">
            <?php else: ?>
                -
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Remplacer la photo</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary">Retour à la liste</a>
    </form>
</div>
