<?php
session_start();
$conn = new mysqli("localhost", "root", "", "abraxaswax", 3307);


$sql = "SELECT id, title, price, image, artist FROM products ORDER BY title ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>

<head>
    <title>Abraxas Wax | Shop</title>
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

    <main class="container">
        <h2>Our Collection</h2>
        <div class="product-grid">

            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<a href="product.php?id=' . $row["id"] . '" class="product">';
                    echo '  <img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["title"]) . '">';
                    echo '  <h3>' . htmlspecialchars($row["title"]) . '</h3>';
                    echo '  <h4>' . htmlspecialchars($row["artist"]) . '</h4>';
                    echo '  <p>$' . number_format($row["price"], 2) . '</p>';
                    echo '</a>';
                }
            } else {
                echo "<p>Sorry, there are no records in our collection right now.</p>";
            }
            
            $conn->close();
            ?>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Abraxas Wax | Eau Claire, WI</p>
    </footer>
</body>