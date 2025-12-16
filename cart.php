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
    <h2>Your Shopping Cart</h2>

    <?php while ($item = $items->fetch_assoc()): ?>
        <div class="product">
            <h3><?= $item["title"] ?></h3>
            <p>$<?= number_format($item["price"], 2) ?></p>

            <form action="remove_from_cart.php" method="post">
                <input type="hidden" name="cart_id" value="<?= $item["cart_id"] ?>">
                <button>Remove</button>
            </form>
        </div>
    <?php endwhile; ?>

    <a class="btn" href="checkout.php">Proceed to Checkout</a>
</div>

</body>
</html>