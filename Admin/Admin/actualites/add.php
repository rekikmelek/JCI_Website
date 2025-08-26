<?php
include '../Components/base_admin.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $auteur  = trim($_POST['auteur'] ?? '');
    $date_publication = date('Y-m-d H:i:s');

    // Vérification image
    $photo_couverture = null;
    if (!empty($_FILES['photo_couverture']['name'])) {
        $uploadDir = '../assets/img/actualites/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileTmp  = $_FILES['photo_couverture']['tmp_name'];
        $fileName = basename($_FILES['photo_couverture']['name']);
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // nom de fichier : titre_date.ext
        $newName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $titre) . '_' . date('Ymd_His') . '.' . $ext;
        $target  = $uploadDir . $newName;

        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        if (in_array($ext, $allowed)) {
            if (move_uploaded_file($fileTmp, $target)) {
                $photo_couverture = $newName;
            } else {
                $message = "Erreur lors de l'upload de l'image.";
            }
        } else {
            $message = "Format non valide (JPG, JPEG, PNG, WEBP seulement).";
        }
    }

    if ($titre && $contenu && $auteur) {
        $stmt = $pdo->prepare("INSERT INTO actualites (titre, contenu, photo_couverture, date_publication, auteur) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $contenu, $photo_couverture, $date_publication, $auteur]);
        header("Location: index.php");
        exit;
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-3 text-center">Ajouter une Actualité</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" name="titre" id="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="contenu" class="form-label">Contenu</label>
            <textarea name="contenu" id="contenu" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="photo_couverture" class="form-label">Photo de couverture</label>
            <input type="file" name="photo_couverture" id="photo_couverture" class="form-control">
        </div>

        <div class="mb-3">
            <label for="auteur" class="form-label">Auteur</label>
            <input type="text" name="auteur" id="auteur" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Enregistrer</button>
        <a href="index.php" class="btn btn-secondary w-100 mt-2">Annuler</a>
    </form>
</div>
