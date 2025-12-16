<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

$items = [];

if (isset($_GET["product_id"])) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $_GET["product_id"]);
    $stmt->execute();
    $items[] = $stmt->get_result()->fetch_assoc();
} else {
    $stmt = $conn->prepare("
        SELECT products.*
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.user_id = ?
    ");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Checkout | Abraxas Wax</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<header>
    <h1>Abraxas Wax</h1>
    <div id="nav"></div>
    <script>
        fetch("navbar.php").then(r => r.text()).then(d => nav.innerHTML = d);
    </script>
</header>

<div class="shop">
    <h2>Checkout</h2>

    <?php foreach ($items as $item): ?>
        <p><?= $item["title"] ?> — $<?= number_format($item["price"], 2) ?></p>
    <?php endforeach; ?>

    <form method="post" action="place_order.php">
        <input placeholder="Full Name" required>
        <input placeholder="Address" required>
        <input placeholder="City" required>
        <input placeholder="Card Number" required>

        <select>
            <option>Delivery</option>
            <option>In-Store Pickup</option>
        </select>

        <button>Place Order</button>
    </form>
</div>

</body>
</html>
