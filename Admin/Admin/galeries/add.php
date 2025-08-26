<?php
include '../Components/base_admin.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre        = trim($_POST['titre'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $date_ajout   = date("Y-m-d H:i:s"); 
    $photo        = null;

    
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
         
            $safeTitre = preg_replace('/[^A-Za-z0-9_\-]/', '_', $titre);
            $safeDate  = date("Ymd_His"); 
            $newName   = $safeTitre . '_' . $safeDate . '.' . $ext;

            $uploadDir = __DIR__ . "/../assets/img/galeries/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $uploadPath = $uploadDir . $newName;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
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
            $stmt = $pdo->prepare("INSERT INTO galeries (titre, description, date_ajout, photo) VALUES (?, ?, ?, ?)");
            $stmt->execute([$titre, $description, $date_ajout, $photo]);
            $message = "✅ Galerie ajoutée avec succès.";
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-3">Ajouter une Galerie</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp" required>
        </div>

        <button type="submit" class="btn btn-success">Ajouter</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
