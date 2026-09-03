<?php
require("session_config.php");
require("config.php");

// LOGIN REQUIRED
if (!isset($_SESSION['username'])) {
  header("Location: Login.php");
  exit();
}

$username = $_SESSION['username'];

// FETCH ALL RESERVATIONS OF THE USER
$res_stmt = mysqli_prepare(
  $conn,
  "SELECT * FROM reservations
     WHERE username = ?
     ORDER BY reservation_id DESC"
);

mysqli_stmt_bind_param($res_stmt, "s", $username);
mysqli_stmt_execute($res_stmt);

$res_result = mysqli_stmt_get_result($res_stmt);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Reservations | Spice Garden</title>

  <link rel="stylesheet" href="style.css">

  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/bg.jpg') center/cover fixed;
      font-family: Poppins, sans-serif;
    }

    /* MAIN WRAPPER */
    .res-wrapper {
      width: 80%;
      margin: 150px auto;
    }

    /* RESERVATION CARD */
    .res-card {
      background: rgba(255, 255, 255, 0.55);
      backdrop-filter: blur(8px);
      padding: 25px;
      margin-bottom: 25px;
      border-radius: 18px;
      box-shadow: 0 0 18px rgba(0, 0, 0, 0.25);
      animation: fadeIn 0.5s ease;
    }

    /* TITLE */
    .res-card h2 {
      font-size: 1.6rem;
      color: #000;
      margin: 0;
    }

    /* DETAILS */
    .res-info {
      margin-top: 10px;
      font-size: 1.05rem;
    }

    .res-info p {
      margin: 5px 0;
      color: #222;
    }

    /* ITEMS TOGGLE LINK */
    .show-items-btn {
      font-size: 1rem;
      font-weight: bold;
      color: black;
      cursor: pointer;
      margin-top: 10px;
      display: inline-block;
      padding: 8px 14px;
      background: rgba(255, 255, 255, 0.7);
      border-radius: 10px;
      border: 1px solid black;
      transition: 0.3s ease;
    }

    .show-items-btn:hover {
      background: black;
      color: white;
    }

    /* ITEMS TABLE */
    .items-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
      display: none;
    }

    .items-table th,
    .items-table td {
      padding: 10px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.2);
      text-align: center;
      font-size: 1rem;
    }

    /* TOTAL */
    .total {
      text-align: right;
      font-size: 1.25rem;
      font-weight: bold;
      margin-top: 12px;
    }

    /* ANIMATIONS */
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>

  <script>
    // Toggle dishes table visibility
    function toggleItems(id) {
      const table = document.getElementById("items-" + id);
      table.style.display = table.style.display === "none" ? "table" : "none";
    }
  </script>

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

  <!-- MAIN CONTENT -->
  <div class="res-wrapper">

    <h1 style="text-align:center; color:black; margin-bottom:30px;">Your Reservations</h1>

    <?php
    if (mysqli_num_rows($res_result) == 0) {
      echo "<h2 style='text-align:center;'>No reservations found.</h2>";
      exit();
    }

    while ($row = mysqli_fetch_assoc($res_result)):
      $rid = $row['reservation_id'];

      // Fetch items for each reservation
      $items_sql = "SELECT * FROM reservation_items WHERE reservation_id = '$rid'";
      $items_res = mysqli_query($conn, $items_sql);

      $total = 0;
    ?>

      <div class="res-card">

        <h2>Reservation No: <?php echo $rid; ?></h2>

        <div class="res-info">
          <p><strong>Date & Time:</strong> <?php echo $row['reservation_time']; ?></p>
          <p><strong>Table Size:</strong> <?php echo $row['people_count']; ?></p>

          <?php if (!empty($row['notes'])): ?>
            <p><strong>Notes:</strong> <?php echo $row['notes']; ?></p>
          <?php endif; ?>
        </div>

        <!-- Show Items Toggle -->
        <div class="show-items-btn" onclick="toggleItems(<?php echo $rid; ?>)">View Ordered Dishes</div>

        <!-- ITEMS TABLE -->
        <table class="items-table" id="items-<?php echo $rid; ?>">
          <tr>
            <th>Dish</th>
            <th>Price (₹)</th>
          </tr>

          <?php while ($item = mysqli_fetch_assoc($items_res)): ?>
            <tr>
              <td><?php echo $item['dish_name']; ?></td>
              <td>₹<?php echo $item['price']; ?></td>
            </tr>

          <?php $total += $item['price'];
          endwhile; ?>

        </table>

        <div class="total">Total: ₹<?php echo $total; ?></div>

      </div>

    <?php endwhile; ?>

  </div>

</body>

</html>