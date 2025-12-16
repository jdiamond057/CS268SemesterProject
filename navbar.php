<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav>
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="shop.php">Shop</a></li>
        <li><a href="cart.php"> Cart</a></li>
        <li><a href="localartists.html">Local Artists</a></li>
        <li><a href="events.html">Events</a></li>
        <li><a href="staffpicks.html">Staff Picks</a></li>
        <li><a href="gallery.html">Gallery</a></li>
        <li><a href="blog.html">Blog / News</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="faq.html">FAQ</a></li>
        <li><a href="contact.html">Contact</a></li>

        <!-- LOGIN / LOGOUT BUTTON -->
        <li class="nav-login">
            <?php if (isset($_SESSION["user_id"])): ?>
                <a href="logout.php" class="login-btn">Logout</a>
            <?php else: ?>
                <a href="login.php" class="login-btn">Login</a>
            <?php endif; ?>
        </li>
    </ul>
</nav>