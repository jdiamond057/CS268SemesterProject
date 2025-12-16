<?php
session_start();
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if ($password === $user["password"]) {
            $_SESSION["user_id"] = $user["id"];
            header("Location: index.html");
            exit;
        }
    }

    $error = "Invalid email or password.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | Abraxas Wax</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="images/record-nobackground.png">
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

<div class="container small">
    <h3>Welcome Back</h3>

    <?php if (isset($error)): ?>
        <p class="auth-error"><?= $error ?></p>
    <?php endif; ?>

    <form method="post">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <p class="auth-switch">
        Don't have an account?
        <a href="register.php">Create one</a>
    </p>
</div>

<footer>
    <p>&copy; 2025 Abraxas Wax | Eau Claire, WI</p>
</footer>

</body>
</html>