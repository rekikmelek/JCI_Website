<?php
include '../Components/base_admin.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("❌ ID manquant.");
}

$message = '';

// Récupérer le partenaire actuel
$stmt = $pdo->prepare("SELECT * FROM partenaires WHERE id = ?");
$stmt->execute([$id]);
$partenaire = $stmt->fetch();

if (!$partenaire) {
    die("❌ Partenaire introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom             = trim($_POST['nom'] ?? '');
    $site_web        = trim($_POST['site_web'] ?? '');
    $description     = trim($_POST['description'] ?? '');
    $ordre_affichage = intval($_POST['ordre_affichage'] ?? 0);

    $logo = $partenaire['logo']; // garder l’ancien logo par défaut

    // Gestion du nouveau logo (si uploadé)
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
            $stmt = $pdo->prepare("UPDATE partenaires 
                                   SET nom=?, logo=?, site_web=?, description=?, ordre_affichage=? 
                                   WHERE id=?");
            $stmt->execute([$nom, $logo, $site_web, $description, $ordre_affichage, $id]);

            $message = "✅ Partenaire mis à jour avec succès.";
            // Recharger les nouvelles données
            $stmt = $pdo->prepare("SELECT * FROM partenaires WHERE id = ?");
            $stmt->execute([$id]);
            $partenaire = $stmt->fetch();
        } catch (PDOException $e) {
            $message = "❌ Erreur lors de la mise à jour : " . $e->getMessage();
        }
    }
}
?>

<div class="container mt-4" style="max-width: 600px;">
    <h2 class="mb-3 text-center">Modifier un Partenaire</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($partenaire['nom']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Logo actuel</label><br>
            <?php if (!empty($partenaire['logo'])): ?>
                <img src="../assets/img/partenaires/<?= htmlspecialchars($partenaire['logo']) ?>" alt="Logo" style="max-height:80px;">
            <?php else: ?>
                <span>Aucun logo</span>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label">Nouveau Logo (optionnel)</label>
            <input type="file" name="logo" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Site Web</label>
            <input type="url" name="site_web" class="form-control" value="<?= htmlspecialchars($partenaire['site_web']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"><?= htmlspecialchars($partenaire['description']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Ordre d'affichage</label>
            <input type="number" name="ordre_affichage" class="form-control" value="<?= htmlspecialchars($partenaire['ordre_affichage']) ?>">
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="index.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
