<?php
require_once '../Admin/Admin/Config/config.php';

$result = $conn->query("SELECT * FROM galeries ORDER BY id DESC");
$galeries = [];
while ($row = $result->fetch_assoc()) {
    $galeries[] = $row;
}
header('Content-Type: application/json');
echo json_encode($galeries);
?>