<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../Admin/Admin/Config/config.php';

$evenements = [];
$sql = "SELECT * FROM evenements ORDER BY date_evenement DESC";
$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $evenements[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($evenements);
?>
