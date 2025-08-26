<?php
require_once '../Admin/Admin/Config/config.php';

$result = $conn->query("SELECT * FROM partenaires ORDER BY nom ASC");
$partenaires = [];
while ($row = $result->fetch_assoc()) {
    $partenaires[] = $row;
}
header('Content-Type: application/json');
echo json_encode($partenaires);
?>