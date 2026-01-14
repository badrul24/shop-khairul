<?php
include_once 'dbconnect.php';
$id_cart = $_POST['id_cart'];
$sql = "DELETE FROM cart WHERE id_cart = $id_cart";
if ($conn->query($sql)) {
    echo json_encode(["success" => true]);
}
?>