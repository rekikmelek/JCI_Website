<?php
require_once '../Admin/Admin/Config/config.php';

$result = $conn->query("SELECT * FROM actualites ORDER BY date DESC");
$actualites = [];
while ($row = $result->fetch_assoc()) {
    $actualites[] = $row;
}
header('Content-Type: application/json');
echo json_encode($actualites);
?>