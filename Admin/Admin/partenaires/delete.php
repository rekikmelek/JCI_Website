<?php
include '../Components/base_admin.php'; 

if (isset($_partenaires['id'])) {
    $id = $_partenaires['id'];

    $stmt = $pdo->prepare("DELETE FROM partenaires WHERE id = ?");
    $stmt->execute([$id]);

    echo "success"; 
}
?>