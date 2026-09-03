<?php

require("session_config.php");

// LOGIN REQUIRED to add dishes
if (!isset($_SESSION['username'])) {
    header("Location: Login.php");
    exit();
}

// ONLY accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: menu.php");
    exit();
}

if (
    !isset($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
) {
    http_response_code(403);
    die("Invalid CSRF token.");
}



// Validate POST values
if (!isset($_POST['dish']) || !isset($_POST['price'])) {
    header("Location: menu.php?error=invalid_data");
    exit();
}

$dish = $_POST['dish'];

// Server-side menu and price list
$menu_prices = [
    "Butter Naan" => 70,
    "Hyderabadi Biryani" => 349,
    "Chicken Tandoori" => 299,
    "Butter Chicken" => 299,
    "Samosa" => 25,
    "Paneer Tikka" => 199,
    "Rogan Josh" => 379,
    "Pav Bhaji" => 110,

    "Lasagna" => 399,
    "Bruschetta" => 149,
    "Spaghetti" => 259,
    "Pesto Pasta" => 319,
    "Arancini (Rice Balls)" => 259,
    "Caprese Salad" => 199,

    "Spring Rolls" => 129,
    "Hakka Noodles" => 179,
    "Mapo Tofu" => 249,
    "Kung Pao Chicken" => 299,
    "Dumplings" => 159,
    "Chow Mein" => 169,
    "Dim Sum" => 279,

    "Tiramisu" => 349,
    "Brownies" => 149,
    "Macarons" => 199,
    "Pudding" => 149,
    "Gulab Jamun" => 99,
    "Mooncakes" => 249,
    "Cheesecake" => 299,
    "Steamed Sponge Cake" => 99,
    "Rasmalai" => 129
];

// Reject dishes that are not in the official menu
if (!array_key_exists($dish, $menu_prices)) {
    header("Location: menu.php?error=invalid_dish");
    exit();
}

// Use the server-side price.
// Never trust the price sent by the browser.
$price = $menu_prices[$dish];

// Create cart if it does not exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add trusted item to cart
$_SESSION['cart'][] = [
    "dish" => $dish,
    "price" => $price
];

// Redirect back to menu
header("Location: menu.php?added=1");
exit();
