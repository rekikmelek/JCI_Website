<?php
include '../Components/base_admin.php'; 

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID manquant.");
}

$stmt = $pdo->prepare("SELECT * FROM actualites WHERE id = ?");
$stmt->execute([$id]);
$actualite = $stmt->fetch();

if (!$actualite) {
    die("Actualité introuvable.");
}

$message = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');
    $auteur  = trim($_POST['auteur'] ?? '');
    $photo   = $actualite['photo_couverture']; 


    if (!empty($_FILES['photo_couverture']['name'])) {
        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['photo_couverture']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed)) {
            $newName = uniqid("actu_", true) . "." . $ext;
            $target = "../assets/img/actualites/" . $newName;

            if (move_uploaded_file($_FILES['photo_couverture']['tmp_name'], $target)) {
                $photo = $newName;
            } else {
                $message = "❌ Erreur lors de l’upload de l’image.";
            }
        } else {
            $message = "❌ Format d’image non autorisé.";
        }
    }

    if (empty($message)) {
        try {
            $stmt = $pdo->prepare("UPDATE actualites 
                                   SET titre = ?, contenu = ?, auteur = ?, photo_couverture = ? 
                                   WHERE id = ?");
            $stmt->execute([$titre, $contenu, $auteur, $photo, $id]);
            $message = "✅ Actualité mise à jour avec succès.";
           
            $stmt = $pdo->prepare("SELECT * FROM actualites WHERE id = ?");
            $stmt->execute([$id]);
            $actualite = $stmt->fetch();
        } catch (PDOException $e) {
            $message = "❌ Erreur SQL : " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4" style="max-width: 700px;">
    <h2 class="mb-3 text-center">Modifier une actualité</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Titre</label>
            <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($actualite['titre']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenu</label>
            <textarea name="contenu" class="form-control" rows="4" required><?= htmlspecialchars($actualite['contenu']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Auteur</label>
            <input type="text" name="auteur" class="form-control" value="<?= htmlspecialchars($actualite['auteur']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Photo de couverture (laisser vide pour garder l’ancienne)</label>
            <input type="file" name="photo_couverture" class="form-control">
            <?php if ($actualite['photo_couverture']): ?>
                <p>Image actuelle :</p>
                <img src="../assets/img/actualites/<?= htmlspecialchars($actualite['photo_couverture']) ?>" 
                     alt="Photo actuelle" style="max-width:150px;">
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
