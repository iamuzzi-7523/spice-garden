<?php
require("session_config.php");

// LOGIN PROTECTION
if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Your Table | Spice Garden</title>

  <link rel="stylesheet" href="style.css">

  <style>
    /* PAGE BACKGROUND */
    body {
      margin: 0;
      padding: 0;
      background: url('images/bg.jpg') center/cover fixed;
      font-family: Poppins, sans-serif;
    }

    /* MAIN CART CONTAINER */
    .cart-box {
      width: 80%;
      margin: 120px auto;
      padding: 25px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(8px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.25);
    }

    /* TABLE STYLING */
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
      color: #111;
    }

    th {
      font-size: 1.2rem;
      font-weight: bold;
      color: #000;
    }

    /* BUTTONS */
    button {
      padding: 10px 22px;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      background: #0c0c0c;
      color: white;
      font-weight: bold;
      transition: 0.3s ease;
    }

    button:hover {
      background: white;
      color: black;
      border: 1px solid black;
      transform: scale(1.05);
    }

    /* TOTAL PRICE BOX */
    .total-box {
      text-align: right;
      margin-top: 20px;
      font-size: 1.4rem;
      font-weight: bold;
      color: #000;
    }

    /* CHECKOUT BUTTON */
    .checkout-btn {
      margin-top: 25px;
      display: flex;
      justify-content: flex-end;
      gap: 10px;
    }

    .checkout-btn a button {
      font-size: 1.1rem;
    }
  </style>

</head>

<body>

  <!-- HEADER (DYNAMIC PROFILE SYSTEM) -->
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


  <!-- CART BOX -->
  <div class="cart-box">

    <h1 class="Spice_Garden" style="text-align:center; ; margin-bottom:20px;">Your Selected Dishes</h1>

    <?php
    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
      echo "<h2 style='text-align:center;'>Your table is empty.</h2>";
      echo "<p style='text-align:center; margin-top:10px;'>
            <a href='menu.php'><button>Go to Menu</button></a>
          </p>";
      exit();
    }
    ?>

    <table>
      <tr>
        <th>Dish</th>
        <th>Price (₹)</th>
        <th>Remove</th>
      </tr>

      <?php
      $total = 0;

      foreach ($_SESSION['cart'] as $index => $item) {
      ?>
        <tr>
          <td class="Spice_Garden">
            <?= htmlspecialchars($item['dish']) ?>
          </td>

          <td>
            ₹<?= htmlspecialchars($item['price']) ?>
          </td>

          <td>
            <form action="remove_item.php" method="POST">
              <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

              <input
                type="hidden"
                name="index"
                value="<?= htmlspecialchars($index) ?>">

              <button
                type="submit"
                class="cta-btn"
                style="margin-top:0 !important">
                Remove
              </button>
            </form>
          </td>
        </tr>
      <?php
        $total += $item['price'];
      }
      ?>
    </table>

    <div class="total-box">
      Total: ₹<?php echo $total; ?>
    </div>

    <div class="checkout-btn">
      <a href="menu.php" style="padding: 5px;">
        <button type="button">Return to Menu</button>
      </a>

      <a href="checkout.php" style="padding: 5px;">
        <button type="button">Proceed to Checkout</button>
      </a>
    </div>

  </div>

</body>

</html>