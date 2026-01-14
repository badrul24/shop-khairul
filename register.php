<?php
include_once 'dbconnect.php';

$fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
$email    = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if(empty($fullname) || empty($email) || empty($password)){
    echo json_encode(["success" => false, "message" => "Data tidak lengkap"]);
    exit;
}

$check = $conn->prepare("SELECT email FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Email sudah terdaftar"]);
} else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $stat = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
    $stat->bind_param("sss", $fullname, $email, $hashed_password);
    
    if ($stat->execute()) {
        echo json_encode(["success" => true, "message" => "Registrasi Berhasil"]);
    } else {
        echo json_encode(["success" => false, "message" => "Gagal Registrasi: " . $conn->error]);
    }
}
?>