<?php
session_start();
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);

$id = $_GET["id"] ?? null;
if (!$id) {
    header("Location: shop.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= htmlspecialchars($product["title"]) ?> | Abraxas Wax</title>
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

<main class="product-page">
    <div class="product-layout">
        <div class="product-image">
            <img src="<?= $product["image"] ?>" alt="<?= htmlspecialchars($product["title"]) ?>">
        </div>

        <div class="product-info">
            <h2><?= htmlspecialchars($product["title"]) ?></h2>
            <p class="price">$<?= number_format($product["price"], 2) ?></p>
            <p><strong>In Stock:</strong> <?= $product["stock"] ?></p>

            <p class="description"><?= $product["description"] ?></p>

            <div class="product-actions">
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                    <button type="submit">Add to Cart</button>
                </form>

                <form action="checkout.php" method="get">
                    <input type="hidden" name="product_id" value="<?= $product["id"] ?>">
                    <button class="buy-now">Buy Now</button>
                </form>
            </div>
        </div>
    </div>

    <a class="btn" href="shop.php">← Back to Shop</a>
</main>

</body>
</html>
