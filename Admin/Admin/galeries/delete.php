<?php
include '../Components/base_admin.php'; 

if (isset($_galeries['id'])) {
    $id = $_galeries['id'];

    $stmt = $pdo->prepare("DELETE FROM galeries WHERE id = ?");
    $stmt->execute([$id]);

    echo "success"; 
}
?>