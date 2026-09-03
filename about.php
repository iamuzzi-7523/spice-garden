<!-- Header -->
<?php

require("session_config.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Restaurant Website</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    main {
      min-height: calc(100vh - 160px);
      background: rgba(247, 246, 246, 0.55);
      border-radius: 20px;
      margin: 40px;
      padding: 60px 40px;
      backdrop-filter: blur(6px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      color: #111;
      font-family: Arial, Helvetica, sans-serif;
    }

    .about-heading {
      text-align: center;
      color: #111;
      font-size: 2.8rem;
      margin-bottom: 20px;
      font-weight: bold;
    }

    .about-heading span {
      color: orange;
      font-family: "Permanent Marker", cursive;
    }

    .about-intro {
      text-align: center;
      font-size: 1.2rem;
      color: #0c0c0c;
      max-width: 850px;
      margin: 0 auto 50px;
      line-height: 1.7;
    }

    .about-content {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-wrap: wrap;
      gap: 40px;
    }

    .about-content img {
      width: 350px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .about-content img:hover {
      transform: scale(1.05);
    }

    .about-text {
      flex: 1;
      min-width: 320px;
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(8px);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
    }

    .about-text h2 {
      font-size: 2rem;
      color: #0c0c0c;
      margin-bottom: 15px;
    }

    .about-text p {
      font-size: 1.1rem;
      color: #111;
      line-height: 1.7;
      margin-bottom: 20px;
    }

    .team-section {
      margin-top: 60px;
      text-align: center;
      color: #0c0c0c;
    }

    .team-section h2 {
      font-size: 2.2rem;
      margin-bottom: 25px;
    }

    .team-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 40px;
    }

    .team-member {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      padding: 20px;
      width: 240px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-member:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 18px rgba(0, 0, 0, 0.4);
    }

    .team-member img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 15px;
      margin-bottom: 12px;
    }

    .team-member h3 {
      font-size: 1.3rem;
      /* color: #090909; */
      margin-bottom: 5px;
    }

    .team-member p {
      font-size: 1rem;
      color: #0f0f0f;
    }
  </style>
</head>

<body>


  <header>
    <div class="nav-links">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="contact.php">Contact</a>
      <a href="cart.php">Your Table</a>
    </div>

    <?php if (isset($_SESSION['username'])): ?>
      <div class="profile-menu">
        <img src="images/profile.png" class="profile-icon" />

        <div class="dropdown">
          <p>
            Welcome,
            <?php echo $_SESSION['username']; ?>
          </p>
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

  <!-- Main Section -->
  <main>
    <h1 class="about-heading">About <span>Spice Garden</span></h1>
    <p class="about-intro">
      Welcome to <strong>Spice Garden</strong>, where culinary passion meets
      tradition. We’re a family of food lovers dedicated to serving authentic
      flavors with modern presentation and warm hospitality.
    </p>

    <div class="about-content">
      <img
        src="./images/Restaurant/interior_2.jpg"
        alt="Restaurant Interior" />
      <div class="about-text">
        <h2>Our Story</h2>
        <p>
          Founded with a dream to bring the true taste of World to your plate,
          <strong class="Spice_Garden">Spice Garden</strong> began as a small
          family-run eatery and has grown into a beloved destination for food
          enthusiasts.
        </p>
        <p>
          Every dish is crafted with premium ingredients, authentic spices,
          and love — ensuring a dining experience that feels like home, yet
          tastes extraordinary.
        </p>
      </div>
    </div>

    <section class="team-section">
      <h2>Meet Our Team</h2>
      <div class="team-container">
        <div class="team-member">
          <img src="./images/Chef's/Chef_1/Chef_1.png" alt="Chef Rahul" />
          <h3 class="Spice_Garden">Chef Rahul</h3>
          <p>Head Chef — Indian Cuisine Specialist</p>
        </div>

        <div class="team-member">
          <img src="./images/Chef's/Chef_3/Chef_3.png" alt="Chef David" />
          <h3 class="Spice_Garden">Chef David</h3>
          <p>Continental Cuisine Expert</p>
        </div>

        <div class="team-member">
          <img src="./images/Chef's/Chef_2/Chef_2.png" alt="Chef Anita" />
          <h3 class="Spice_Garden">Chef Anita</h3>
          <p>Pastry Expert & Dessert Artist</p>
        </div>

        <div class="team-member">
          <img
            src="./images/Chef's/Chef_4/Chef_4.png"
            alt="Chef Chan Yan-tak" />
          <h3 class="Spice_Garden">Chef Chan Yan-tak</h3>
          <p>Skilled Chinese Cuisine Expert</p>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>&copy; 2025 Spice Garden. All Rights Reserved.</footer>
</body>

</html>