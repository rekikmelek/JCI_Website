<?php
require_once '../Admin/Admin/Config/config.php';

$result = $conn->query("SELECT * FROM membres ORDER BY nom ASC");
$membres = [];
while ($row = $result->fetch_assoc()) {
    $membres[] = $row;
}
header('Content-Type: application/json');
echo json_encode($membres);
?>