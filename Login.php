<?php
require "connection.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username']; 
    $password = $_POST['password']; 

    $sql = "SELECT * FROM register WHERE name = ? AND password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        session_start();
        $_SESSION['user'] = $username;
        header("Location: info.php");
        exit;
    } else {
        echo "❌ Username or password is incorrect";
    }
}
?>
