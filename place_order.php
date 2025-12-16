<?php
session_start();
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();

header("Location: index.html");
