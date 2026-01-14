<?php
include_once 'dbconnect.php';

$email    = $_POST['email'];
$password = $_POST['password'];

$stat = $conn->prepare("SELECT id, fullname, password FROM users WHERE email = ?");
$stat->bind_param("s", $email);
$stat->execute();
$stat->bind_result($id, $fullname, $hashed_password);

if ($stat->fetch()) {
    if (password_verify($password, $hashed_password)) {
        echo json_encode([
            "success" => true, 
            "message" => "Login Berhasil",
            "user_id" => $id,
            "user" => [
                "id" => $id,
                "fullname" => $fullname,
                "email" => $email
            ]
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Password Salah"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Email tidak ditemukan"]);
}
?>