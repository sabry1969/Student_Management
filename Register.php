<?php
require "connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("❌ Access Denied");
}

$name        = $_POST['name'];
$national_id = $_POST['id'];
$nationality = $_POST['nationality'];
$gender      = $_POST['gender'];
$phone       = $_POST['phone'];
$birthdate   = $_POST['birthdate'];
$email       = $_POST['email'];
$password    = $_POST['password'];

$sql = "INSERT INTO register 
(name, id, nationality, gender, phone, birthdate, email, password)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $connection->prepare($sql);
$stmt->bind_param(
    "ssssssss",
    $name,
    $national_id,
    $nationality,
    $gender,
    $phone,
    $birthdate,
    $email,
    $password
);

if ($stmt->execute()) {
    header("Location: login.html");
    exit;
} else {
    echo "❌ Error: " . $stmt->error;
}
