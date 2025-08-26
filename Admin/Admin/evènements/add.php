<?php
include '../Components/base_admin.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $annee = trim($_POST['annee'] ?? '');
    $date_evenement = trim($_POST['date_evenement'] ?? '');
    $photo = '';
    if (!empty($_FILES['photo']['name'])) {
        $uploads_dir = "../assets/img/events/";
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        $extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($extension, $allowed)) {
            $safeTitre = preg_replace('/[^A-Za-z0-9_-]/', '_', $titre);
            $safeDate = preg_replace('/[^0-9]/', '-', $date_evenement);
            $photo = $safeTitre . "_" . $safeDate . "." . $extension;
            $target = $uploads_dir . $photo;
            move_uploaded_file($_FILES['photo']['tmp_name'], $target);
        } else {
            $message = "Format d'image non valide. Formats acceptés : JPG, JPEG, PNG, WEBP.";
        }
    }
    if ($titre && $description && $annee && $date_evenement) {
        $stmt = $pdo->prepare("INSERT INTO evènements (titre, description, annee, date_evenement, photo_couverture) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $description, $annee, $date_evenement, $photo]); 
        header("Location: index.php");
        exit;
    } else {
        $message = "Veuillez remplir tous les champs obligatoires.";
    }
}
?>
<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-4 text-center">Ajouter un Événement</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-warning"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Année</label>
            <input type="number" name="annee" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de l'Événement</label>
            <input type="date" name="date_evenement" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control" accept=".jpg,.jpeg,.png,.webp">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>