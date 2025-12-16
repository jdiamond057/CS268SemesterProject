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

    <main class="shop">
        <h2>Our Collection</h2>
        <div class="product-grid">

            <a href="product.php?id=1" class="product">
                <img src="images/dark-side-of-the-moon.jpg" alt="Pink Floyd">
                <h3>Pink Floyd – Dark Side of the Moon</h3>
                <p>$29.99</p>
            </a>

            <a href="product.php?id=2" class="product">
                <img src="images/rumors.jpg" alt="Fleetwood Mac">
                <h3>Fleetwood Mac – Rumours</h3>
                <p>$24.99</p>
            </a>

            <a href="product.php?id=3" class="product">
                <img src="images/abbey-road.jpg" alt="The Beatles">
                <h3>The Beatles – Abbey Road</h3>
                <p>$34.99</p>
            </a>

            <a href="product.php?id=4" class="product">
                <img src="images/igor.jpg" alt="Tyler, the Creator">
                <h3>Tyler, the Creator – Igor</h3>
                <p>$27.99</p>
            </a>

        </div>
    </main>

    <footer>
        <p>&copy; 2025 Abraxas Wax | Eau Claire, WI</p>
    </footer>
</body>