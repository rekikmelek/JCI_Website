<?php
include '../Components/base_admin.php'; 

$id = $_GET['id']; 

$stmt = $pdo->prepare("SELECT * FROM Postes WHERE id = ?");
$stmt->execute([$id]);
$poste = $stmt->fetch();

$success = false;

if (!empty($_POST['name'])) {
    $update = $pdo->prepare("UPDATE Postes SET name = ? WHERE id = ?");
    if ($update->execute([$_POST['name'], $id])) {
        $success = true;
        $poste['name'] = $_POST['name']; 
        echo "<script>window.location.href='index.php';</script>";
        exit; 
    }
}
?>

<div class="container" style="margin-left: 15%; margin-top: 30px;">
    <h2>Modifier le Poste</h2>

    <form method="POST" action="edit.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="name" class="form-label">Nom du Poste</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="<?php echo htmlspecialchars($poste['name']); ?>" 
                   required style="width: 300px;">
        </div>

        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
