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

<div class="container">
    <h2>Checkout</h2>

    <div class="checkout-grid">

        <div>
            <h3>Your Items</h3>
            <?php $total = 0; ?>
            <?php foreach ($items as $item): ?>
                <div class="checkout-item">
                    <img src="<?= $item["image"] ?>" alt="<?= htmlspecialchars($item["title"]) ?>">
                    <div class="checkout-details">
                        <h4><?= $item["title"] ?></h4>
                        <p>$<?= number_format($item["price"], 2) ?></p>
                    </div>
                </div>
                <?php $total += $item["price"]; ?>
            <?php endforeach; ?>
            <hr>
            <p>Total: $<?= number_format($total, 2) ?></p>
        </div>

        <form method="post" action="place_order.php">

            <h3 class="section-title">Billing Information</h3>

            <div class="form-row">
                <input name="first_name" placeholder="First Name" required>
                <input name="last_name" placeholder="Last Name" required>
            </div>

            <input name="billing_address" placeholder="Billing Address" required>
            <input name="billing_city" placeholder="City" required>

            <h3 class="section-title">Payment Details</h3>

            <input name="card_number" placeholder="Card Number" required>

            <div class="form-row">
                <input name="exp_date" placeholder="MM / YY" required>
                <input name="cvv" placeholder="CVV" required>
            </div>

            <h3 class="section-title">Delivery Method</h3>

            <select name="delivery_method" id="deliveryMethod" onchange="toggleDelivery()" required>
                <option value="pickup">In-Store Pickup</option>
                <option value="delivery">Delivery</option>
            </select>

            <div id="deliveryAddress" class="hidden">
                <h3 class="section-title">Delivery Address</h3>
                <input name="delivery_address" placeholder="Delivery Address">
                <input name="delivery_city" placeholder="City">
            </div>

            <button style="margin-top:1.5em;">Place Order</button>
        </form>

    </div>
</div>

<footer>
    <p>&copy; 2025 Abraxas Wax | Eau Claire, WI</p>
</footer>

<script>
function toggleDelivery() {
    const method = document.getElementById("deliveryMethod").value;
    document.getElementById("deliveryAddress").classList.toggle(
        "hidden",
        method !== "delivery"
    );
}
</script>

</body>
</html>