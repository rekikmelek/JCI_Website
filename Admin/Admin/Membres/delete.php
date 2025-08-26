<?php
include '../Components/base_admin.php'; 

if (isset($_membres['id'])) {
    $id = $_membres['id'];

    $stmt = $pdo->prepare("DELETE FROM membres WHERE id = ?");
    $stmt->execute([$id]);

    echo "success"; 
}
?>
