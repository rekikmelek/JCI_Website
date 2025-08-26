<?php include '../Components/base_admin.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $posteName = trim($_POST['posteName'] ?? '');
    if (!empty($posteName)) {
        $stmt = $pdo->prepare("INSERT INTO Postes (name) VALUES (:name)");
        $stmt->execute([':name' => $posteName]);
    
        $message = "Poste '$posteName' added successfully!";
    } else {
        $message = "Poste Name cannot be empty.";
    }
}
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<div class="container" style="margin-left: 15%  ;">
    <form method="POST" action="">
        <div class="form-group col-md-6">
            <label for="posteName">Poste Name:</label>
            <input type="text" class="form-control" id="posteName" name="posteName" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Poste</button>
    </form>
</div>