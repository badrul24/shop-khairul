<?php
include_once 'dbconnect.php';

$id_cart = $_POST['id_cart'];
$qty     = $_POST['qty'];

$sql = "UPDATE cart SET qty = ? WHERE id_cart = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $qty, $id_cart);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false]);
}
?>