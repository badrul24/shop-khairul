<?php
include_once 'dbconnect.php';

$user_id      = $_POST['user_id'];
$product_name = $_POST['product_name'];
$price        = $_POST['price'];
$image        = $_POST['image'];

$check = $conn->prepare("SELECT id_cart, qty FROM cart WHERE user_id = ? AND product_name = ?");
$check->bind_param("is", $user_id, $product_name);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $new_qty = $row['qty'] + 1;
    $update = $conn->prepare("UPDATE cart SET qty = ? WHERE id_cart = ?");
    $update->bind_param("ii", $new_qty, $row['id_cart']);
    if ($update->execute()) {
        echo json_encode(["success" => true, "message" => "Jumlah diperbarui"]);
    }
} else {
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_name, price, image, qty) VALUES (?, ?, ?, ?, 1)");
    $insert->bind_param("isis", $user_id, $product_name, $price, $image);
    if ($insert->execute()) {
        echo json_encode(["success" => true, "message" => "Berhasil ditambah ke keranjang"]);
    }
}
?>