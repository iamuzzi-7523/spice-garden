<?php
require("session_config.php");

// LOGIN REQUIRED
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

// Only accept POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (!isset($_POST['index'])) {
        header("Location: cart.php");
        exit();
    }

    $index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);

    if ($index === false || $index === null || $index < 0) {
        header("Location: cart.php");
        exit();
    }

    // If cart exists and index is valid
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$index])) {

        // Remove that specific item
        unset($_SESSION['cart'][$index]);

        // Reorder array keys to prevent gaps
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }

    // Redirect back to cart
    header("Location: cart.php");
    exit();
}

// Invalid direct access
header("Location: cart.php");
exit();
