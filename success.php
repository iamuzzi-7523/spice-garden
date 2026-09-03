<?php
require("session_config.php");
require("config.php");

// LOGIN REQUIRED
if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  exit();
}

// GET RESERVATION ID FROM URL
if (!isset($_GET['id'])) {
  die("Invalid reservation.");
}

$reservation_id = $_GET['id'];

// FETCH RESERVATION DETAILS
$res_stmt = mysqli_prepare(
  $conn,
  "SELECT * FROM reservations
     WHERE reservation_id = ?
     AND username = ?"
);

mysqli_stmt_bind_param(
  $res_stmt,
  "is",
  $reservation_id,
  $_SESSION['username']
);

mysqli_stmt_execute($res_stmt);

$res_result = mysqli_stmt_get_result($res_stmt);
$res_data = mysqli_fetch_assoc($res_result);


if (!$res_data) {
  die("Reservation not found.");
}

// FETCH ORDERED ITEMS
$items_stmt = mysqli_prepare(
  $conn,
  "SELECT * FROM reservation_items WHERE reservation_id = ?"
);

mysqli_stmt_bind_param($items_stmt, "i", $reservation_id);
mysqli_stmt_execute($items_stmt);

$items_result = mysqli_stmt_get_result($items_stmt);

// CALCULATE TOTAL
$total = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reservation Success | Spice Garden</title>

  <link rel="stylesheet" href="style.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/bg.jpg') center/cover fixed;
      font-family: Poppins, sans-serif;
    }

    /* SUCCESS CARD */
    .success-card {
      width: 60%;
      margin: 150px auto;
      padding: 35px;
      border-radius: 20px;
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(10px);
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.25);
      animation: popIn 0.5s ease forwards;
    }

    /* TITLE */
    .success-card h1 {
      text-align: center;
      color: black;
      margin-bottom: 10px;
    }

    /* SUBTEXT */
    .success-card p {
      text-align: center;
      font-size: 1.1rem;
      margin: 8px 0;
      color: #222;
    }

    /* DETAILS BOX */
    .info-box {
      margin-top: 25px;
      padding: 20px;
      background: rgba(255, 255, 255, 0.35);
      border-radius: 12px;
    }

    .info-box h2 {
      color: #111;
      margin-bottom: 10px;
    }

    /* ITEMS TABLE */
    table {
      width: 100%;
      margin-top: 15px;
      border-collapse: collapse;
    }

    th,
    td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    }

    th {
      font-weight: bold;
    }

    /* TOTAL PRICE */
    .total-box {
      margin-top: 15px;
      font-size: 1.3rem;
      font-weight: bold;
      text-align: right;
    }

    /* BUTTONS */
    .btn-group {
      margin-top: 25px;
      text-align: center;
    }

    button {
      padding: 12px 30px;
      border-radius: 25px;
      border: none;
      cursor: pointer;
      background: black;
      color: white;
      font-size: 1.05rem;
      font-weight: bold;
      margin: 8px;
      transition: 0.3s ease;
    }

    button:hover {
      background: white;
      color: black;
      border: 1px solid black;
    }

    /* ANIMATION */
    @keyframes popIn {
      0% {
        transform: translateY(40px);
        opacity: 0;
      }

      100% {
        transform: translateY(0);
        opacity: 1;
      }
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

  <!-- SUCCESS CARD -->
  <div class="success-card">

    <h1>🎉 Reservation Confirmed!</h1>
    <p>Your reservation was successfully created.</p>
    <p>Reservation ID No: <strong><?php echo $reservation_id; ?></strong></p>

    <div class="info-box">
      <h2>Reservation Details</h2>

      <p><strong>Name:</strong> <?php echo $_SESSION['username']; ?></p>
      <p><strong>Table Size:</strong> <?php echo $res_data['people_count']; ?></p>
      <p><strong>Reservation Time:</strong> <?php echo $res_data['reservation_time']; ?></p>

      <?php if (!empty($res_data['notes'])): ?>
        <p><strong>Notes:</strong> <?php echo $res_data['notes']; ?></p>
      <?php endif; ?>

      <h2 style="margin-top:25px;">Ordered Dishes</h2>

      <table>
        <tr>
          <th>Dish</th>
          <th>Price (₹)</th>
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($items_result)) {
          echo "<tr>
            <td>{$row['dish_name']}</td>
            <td>₹{$row['price']}</td>
          </tr>";
          $total += $row['price'];
        }
        ?>
      </table>

      <div class="total-box">
        Total Amount: ₹<?php echo $total; ?>
      </div>

    </div>

    <div class="btn-group">
      <a href="view_reservations.php"><button>View My Reservations</button></a>
      <a href="index.php"><button>Back to Home</button></a>
    </div>

  </div>

</body>

</html>