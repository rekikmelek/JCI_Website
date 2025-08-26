<?php
require_once '../Admin/Admin/Config/config.php';

$result = $conn->query("SELECT * FROM postes ORDER BY nom ASC");
$postes = [];
while ($row = $result->fetch_assoc()) {
    $postes[] = $row;
}
header('Content-Type: application/json');
echo json_encode($postes);
?>