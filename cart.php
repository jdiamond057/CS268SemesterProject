<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php?redirect=cart.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

$stmt = $conn->prepare("
    SELECT cart.id AS cart_id, products.*
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.user_id = ?
");
$stmt->bind_param("i", $_SESSION["user_id"]);
$stmt->execute();
$items = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Your Cart | Abraxas Wax</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" href="images/record-nobackground.png">
</head>
<body>

<header>
    <h1>Abraxas Wax</h1>
    <div id="nav"></div>
    <script>
        fetch("navbar.php")
            .then(res => res.text())
            .then(data => document.getElementById("nav").innerHTML = data);
    </script>
</header>

<div class="container">
    <h2>Your Shopping Cart</h2>

    <?php if ($items->num_rows === 0): ?>
        <p>Your cart is empty.</p>
    <?php else: ?>
        <div class="product-grid">
            <?php while ($item = $items->fetch_assoc()): ?>
                <div class="product">
                    <img src="<?= htmlspecialchars($item["image"]) ?>" alt="<?= htmlspecialchars($item["title"]) ?>">

                    <h3><?= htmlspecialchars($item["title"]) ?></h3>
                    <p>$<?= number_format($item["price"], 2) ?></p>

                    <form action="remove_from_cart.php" method="post">
                        <input type="hidden" name="cart_id" value="<?= $item["cart_id"] ?>">
                        <button type="submit">Remove</button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
        <a class="btn" href="shop.php">Continue Browsing</a>
        <a class="btn" href="checkout.php" style="margin-left: 1em;">Proceed to Checkout</a>
    <?php endif; ?>
</div>

<footer>
    <p>&copy; 2025 Abraxas Wax | Eau Claire, WI</p>
</footer>

</body>
</html>