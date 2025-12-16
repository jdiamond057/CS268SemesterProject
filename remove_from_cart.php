<?php
session_start();
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

$stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
$stmt->bind_param("i", $_POST["cart_id"]);
$stmt->execute();

header("Location: cart.php");