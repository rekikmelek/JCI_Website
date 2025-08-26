<?php
include '../Components/base_admin.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom             = trim($_POST['nom'] ?? '');
    $site_web        = trim($_POST['site_web'] ?? '');
    $description     = trim($_POST['description'] ?? '');
    $ordre_affichage = intval($_POST['ordre_affichage'] ?? 0);

    $logo = null;

    // Gestion de l’upload du logo
    if (!empty($_FILES['logo']['name'])) {
        $uploadDir = "../assets/img/partenaires/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $safeNom = preg_replace('/[^A-Za-z0-9_\-]/', '_', $nom);
            $newName = $safeNom . "_" . time() . "." . $ext;
            $uploadFile = $uploadDir . $newName;

            if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadFile)) {
                $logo = $newName;
            } else {
                $message = "❌ Erreur lors du téléchargement du logo.";
            }
        } else {
            $message = "❌ Format d'image non valide. (jpg, jpeg, png, webp)";
        }
    }

    if (empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO partenaires (nom, logo, site_web, description, ordre_affichage) 
                                   VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $logo, $site_web, $description, $ordre_affichage]);

            $message = "✅ Partenaire ajouté avec succès.";
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de l'ajout : " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-3 text-center">Ajouter un Partenaire</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Site Web</label>
            <input type="url" name="site_web" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ordre d'affichage</label>
            <input type="number" name="ordre_affichage" class="form-control" value="0">
        </div>

        <button type="submit" class="btn btn-primary">Ajouter</button>
        <a href="index.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
