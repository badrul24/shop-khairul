<?php
include_once 'dbconnect.php';

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $sql = "SELECT * FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $cart_items = [];
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
    }

    echo json_encode($cart_items);
} else {
    echo json_encode(["message" => "User ID tidak ditemukan"]);
}
?>