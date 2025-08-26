<?php
include '../Components/base_admin.php'; 

$id = $_GET['id'] ?? null; 

if (!$id) {
    die("ID manquant.");
}

// Récupération du membre
$stmt = $pdo->prepare("SELECT * FROM membres WHERE id = ?");
$stmt->execute([$id]);
$membre = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$membre) {
    die("Membre introuvable.");
}

$success = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom      = $_POST['nom'] ?? '';
    $Prenom   = $_POST['Prenom'] ?? '';
    $poste_id = $_POST['poste_id'] ?? '';
    $statut   = $_POST['statut'] ?? '';

    $update = $pdo->prepare("UPDATE membres 
        SET nom = ?, Prenom = ?, poste_id = ?, statut = ?
        WHERE id = ?");

    if ($update->execute([$nom, $Prenom, $poste_id, $statut, $id])) {
        $success = true;
        echo "<script>window.location.href='index.php';</script>";
        exit;
    }
}
?>

<div class="container" style="margin-left: 15%; margin-top: 30px; max-width: 600px;">
    <h2>Modifier un membre </h2>

    <form method="POST" action="edit.php?id=<?php echo $id; ?>">

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" 
                   value="<?php echo htmlspecialchars($membre['nom'] ?? ''); ?>" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prenom</label>
            <input type="text" name="Prenom" id="Prenom" class="form-control" 
                   value="<?php echo htmlspecialchars($membre['Prenom'] ?? ''); ?>">
        </div> 

        <div class="mb-3">
            <label for="poste_id" class="form-label">Poste</label>
            <input type="text" name="poste_id" id="poste_id" class="form-control" 
                   value="<?php echo htmlspecialchars($membre['poste_id'] ?? ''); ?>">
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-control">
                <option value="actif" <?php if(($membre['statut'] ?? '')=='actif') echo 'selected'; ?>>Actif</option>
                <option value="inactif" <?php if(($membre['statut'] ?? '')=='inactif') echo 'selected'; ?>>Inactif</option>
                <option value="honoraire" <?php if(($membre['statut'] ?? '')=='honoraire') echo 'selected'; ?>>Honoraire</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
