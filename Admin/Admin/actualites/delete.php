<?php
include '../Components/base_admin.php'; 

if (isset($_actualites['id'])) {
    $id = $_actualites['id'];

    $stmt = $pdo->prepare("DELETE FROM actualites WHERE id = ?");
    $stmt->execute([$id]);
   
    echo "success"; 
}
?>