<?php
include '../Components/base_admin.php';

// Récupérer toutes les postes pour le select
$stmt = $pdo->query("SELECT * FROM Postes");
$postes = $stmt->fetchAll();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom            = trim($_POST['nom'] ?? '');
    $prenom         = trim($_POST['prenom'] ?? '');
    $poste_id       = trim($_POST['poste_id'] ?? '');
    $date_adhesion  = trim($_POST['date_adhesion'] ?? '');
    $photo          = trim($_POST['photo'] ?? '');
    $cin            = trim($_POST['cin'] ?? '');
    $carte_membre   = trim($_POST['carte_membre'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $statut         = $_POST['statut'] ?? '';

    try {
        $stmt = $pdo->prepare("INSERT INTO Membres 
            (nom, prenom, poste_id, date_adhesion, photo, Numero_cin, Numero_carte_membre, email, statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $poste_id, $date_adhesion, $photo, $cin, $carte_membre, $email, $statut]);

        $message = "✅ Membre ajouté avec succès !";
    } catch (PDOException $e) {
        $message = "❌ Erreur lors de l'ajout : " . $e->getMessage();
    }
}
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<div class="container" style="margin-left: 15%; margin-top: 30px; max-width: 600px;">
    <h2>Ajouter un Nouveau Membre</h2>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" name="prenom" id="prenom" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="poste_id" class="form-label">Poste</label>
            <select name="poste_id" id="poste_id" class="form-control" required>
                <option value="">Veuillez sélectionner un poste</option>
                <?php foreach ($postes as $poste): ?>
                    <option value="<?= $poste['id'] ?>"><?= htmlspecialchars($poste['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_adhesion" class="form-label">Date d’adhésion</label>
            <input type="date" name="date_adhesion" id="date_adhesion" class="form-control">
        </div>

        <div class="mb-3">
            <label for="cin" class="form-label">Numéro CIN</label>
            <input type="text" name="cin" id="cin" class="form-control">
        </div>

        <div class="mb-3">
            <label for="carte_membre" class="form-label">Numéro Carte Membre</label>
            <input type="text" name="carte_membre" id="carte_membre" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select name="statut" id="statut" class="form-control">
                <option value="">Veuillez sélectionner un statut</option>
                <option value="actif">Actif</option>
                <option value="inactif">Inactif</option>
                <option value="honoraire">Honoraire</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Ajouter le Membre</button>
        <a href="index.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
