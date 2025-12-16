<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=cart.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);
$user_id = $_SESSION["user_id"];
$product_id = $_POST["product_id"];

$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id) VALUES (?, ?)");
$stmt->bind_param("ii", $user_id, $product_id);
$stmt->execute();

header("Location: cart.php");
