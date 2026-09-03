<?php

require("session_config.php");
require("config.php");

// LOGIN PROTECTION
if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  exit();
}

// If cart is empty
if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
  header("Location: cart.php");
  exit();
}

// FORM SUBMISSION HANDLER
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // CSRF PROTECTION
  if (
    !isset($_POST['csrf_token']) ||
    !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])
  ) {
    http_response_code(403);
    die("Invalid CSRF token.");
  }

  $username = $_SESSION["username"];
  $people = $_POST["people"];
  $time = $_POST["time"];
  $notes = $_POST["notes"];

  // Insert reservation
  $stmt = mysqli_prepare(
    $conn,
    "INSERT INTO reservations (username, people_count, reservation_time, notes)
     VALUES (?, ?, ?, ?)"
  );

  mysqli_stmt_bind_param($stmt, "siss", $username, $people, $time, $notes);
  mysqli_stmt_execute($stmt);

  $reservation_id = mysqli_insert_id($conn);

  // Insert items
  foreach ($_SESSION["cart"] as $item) {

    $dish = $item["dish"];
    $price = $item["price"];

    $item_stmt = mysqli_prepare(
      $conn,
      "INSERT INTO reservation_items (reservation_id, dish_name, price)
       VALUES (?, ?, ?)"
    );

    mysqli_stmt_bind_param(
      $item_stmt,
      "isd",
      $reservation_id,
      $dish,
      $price
    );

    mysqli_stmt_execute($item_stmt);
  }

  // Clear cart
  unset($_SESSION["cart"]);

  // Redirect to success page
  header("Location: success.php?id=$reservation_id");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout | Spice Garden</title>

  <link rel="stylesheet" href="style.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/bg.jpg') center/cover fixed;
      font-family: Poppins, sans-serif;
    }

    .checkout-box {
      width: 80%;
      margin: 120px auto;
      padding: 25px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(8px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
    }

    h1,
    h2 {
      text-align: center;
      color: #111;
    }

    /* ORDER SUMMARY TABLE */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th,
    td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid rgba(0, 0, 0, 0.2);
      font-size: 1.1rem;
    }

    th {
      font-size: 1.2rem;
      font-weight: bold;
    }

    .total-box {
      text-align: right;
      font-size: 1.4rem;
      font-weight: bold;
      margin-top: 10px;
    }

    /* FORM */
    form {
      margin-top: 40px;
    }

    input,
    textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid black;
      border-radius: 12px;
      margin-top: 10px;
      background: rgba(255, 255, 255, 0.8);
      font-size: 1rem;
    }

    label {
      font-weight: bold;
      color: #111;
      margin-top: 10px;
      display: block;
    }

    /* BUTTON */
    button {
      padding: 12px 30px;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      background: black;
      color: white;
      font-size: 1.1rem;
      font-weight: bold;
      transition: 0.3s ease;
      margin-top: 20px;
    }

    button:hover {
      background: white;
      color: black;
      border: 1px solid black;
    }
  </style>

</head>

<body>

  <!-- HEADER -->
  <header>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="cart.php">Your Table</a>
    </div>

    <?php if (isset($_SESSION['username'])): ?>
      <div class="profile-menu">
        <img src="images/profile.png" class="profile-icon">
        <div class="dropdown">
          <p>Welcome, <?php echo $_SESSION['username']; ?></p>
          <a href="view_reservations.php">View Reservations</a>
          <a href="logout.php">Logout</a>
        </div>
      </div>
    <?php else: ?>
      <div class="auth-links">
        <a href="Login.php" class="signup-btn">Login</a>
        <a href="SignUp.php" class="signup-btn">Sign Up</a>
      </div>
    <?php endif; ?>
  </header>

  <!-- CHECKOUT BOX -->
  <div class="checkout-box">

    <h1 class="Spice_Garden">Reservation Checkout</h1>

    <h2>Order Summary</h2>

    <table>
      <tr>
        <th>Dish</th>
        <th>Price (₹)</th>
      </tr>

      <?php
      $total = 0;
      foreach ($_SESSION['cart'] as $item) {
        echo "<tr>
            <td class='Spice_Garden' style='font-weight:bold;'>{$item['dish']}</td>
            <td>₹{$item['price']}</td>
          </tr>";
        $total += $item['price'];
      }
      ?>
    </table>

    <div class="total-box">
      <span class="Spice_Garden">Total</span>: ₹<?php echo $total; ?>
    </div>

    <h2 class="Spice_Garden">Reservation Details</h2>

    <form method="POST">

      <input
        type="hidden"
        name="csrf_token"
        value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

      <label>Number of People</label>
      <input type="number" name="people" required min="1">

      <label>Reservation Date & Time</label>
      <input type="datetime-local" name="time" required>

      <label>Notes</label>
      <textarea
        name="notes"
        rows="4"
        placeholder="Any special requests?"></textarea>

      <button type="submit">Confirm Reservation</button>

    </form>

  </div>

</body>

</html>