<?php
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"]; // PLAINTEXT (for class only)

    $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();

    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | Abraxas Wax</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Abraxas Wax</h1>
    <div id="nav"></div>
    <script>
        fetch("navbar.php").then(res => res.text()).then(data => {
            document.getElementById("nav").innerHTML = data;
        });
    </script>
</header>

<div class="about auth-box">
    <h3>Create an Account</h3>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Register</button>
    </form>

    <p class="auth-switch">
        Already have an account?
        <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>
