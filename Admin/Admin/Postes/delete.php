<?php
include '../Components/base_admin.php'; // Connexion PDO

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $pdo->prepare("DELETE FROM Postes WHERE id = ?");
    $stmt->execute([$id]);

    echo "success"; // réponse pour JavaScript
}
?>
