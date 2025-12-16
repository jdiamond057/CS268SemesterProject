<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "abraxaswax";

$conn = new mysqli($host, $user, $pass, "", 3307);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS $dbname");
$conn->select_db($dbname);

// Users table
$conn->query("
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
)
");

// Products table
$conn->query("
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    artist VARCHAR(255) NOT NULL,
    title VARCHAR(255) NOT NULL,
    price DECIMAL(6,2) NOT NULL,
    stock INT NOT NULL,
    image VARCHAR(255),
    description TEXT
)
");

echo "Database setup complete.";