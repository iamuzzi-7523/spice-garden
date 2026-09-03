<?php
ob_start();
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
    .Spice_Garden {
      color: orange;
      font-weight: bold;
      font-family: "Permanent Marker", cursive;
      font-style: normal;
    }

    main {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      color: white;
      text-align: center;
      min-height: fit-content;
      background: rgba(247, 246, 246, 0.55);
      margin-top: 120px;
      border-radius: 20px;
      margin: 40px;
      padding: 60px 20px;
      backdrop-filter: blur(5px);
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }

    main h1 {
      font-size: 3rem;
      margin-bottom: 15px;
      color: #111111;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }

    main p {
      font-size: 1.2rem;
      max-width: 700px;
      line-height: 1.6;
      margin-bottom: 35px;
      color: #0c0c0c;
    }

    .menu-btn {
      display: inline-block;
      background: #090909;
      color: #f9f5f5;
      padding: 12px 30px;
      border-radius: 25px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .menu-btn:hover {
      background: rgb(248, 246, 246);
      color: rgb(12, 12, 12);
      transform: scale(1.05);
      border: 1px solid black;
    }

    /* About teaser section below hero */
    .about-preview {
      /* display: inline; */
      margin-top: 50px;
      background: rgba(255, 255, 255, 0.1);
      padding: 40px 30px;
      border-radius: 15px;
      backdrop-filter: blur(6px);
      text-align: left;
      /* Aligns text to the left for better readability */
    }

    .about-preview h2 {
      font-size: 2rem;
      margin-bottom: 15px;
      color: #0c0c0c;
    }

    .about-preview p {
      font-size: 1.1rem;
      color: #111111;
      line-height: 1.7;
    }

    .about-section {
      display: flex;
      align-items: center;
      gap: 30px;
      /* Adds space between the image and the text box */
      margin-top: 40px;
      /* Adds some space above this section */
      max-width: 950px;
      /* Optional: controls the max width of this section */
      width: 100%;
    }

    .chef_img {
      max-width: 300px;
      flex-shrink: 0;
    }

    .special-dishes {
      margin-top: 70px;
      text-align: center;
      color: rgb(13, 13, 13);
    }

    .special-dishes h2 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
    }

    .dish-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
    }

    .dish-card {
      background: rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      padding: 20px;
      width: 260px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .dish-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
    }

    .dish-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 15px;
      margin-bottom: 15px;
    }

    .dish-card h3 {
      font-size: 1.4rem;
      /* color: #060606; */
      margin-bottom: 8px;
    }

    .dish-card p {
      font-size: 0.95rem;
      color: #050505;
      line-height: 1.5;
    }

    .dish-card a {
      display: inline-block;
      margin-top: 12px;
      background: #090909;
      color: #f9f5f5;
      padding: 12px 30px;
      border-radius: 25px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .dish-card a:hover {
      background: rgb(248, 246, 246);
      color: rgb(12, 12, 12);
      transform: scale(1.05);
      border: 1px solid black;
    }
  </style>
</head>

<body>
  <!-- Header -->


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


  <!-- Main Section -->
  <main>
    <h1>Welcome to <span class="Spice_Garden">Spice Garden </span></h1>

    <p>
      Discover the authentic flavors of India and beyond, cooked with love and
      served with warmth. Taste the tradition in every bite.
    </p>
    <a href="menu.php" class="menu-btn">Explore Menu</a>
    <div class="about-section">
      <img
        src="./images/Chef's/Chef_1/Chef_1.png"
        class="chef_img"
        alt="image of a animated chef"
        width="300px " />

      <div class="about-preview">
        <h2>About Our Restaurant</h2>
        <p>
          At Spice Garden, we believe dining is more than just food — it’s an
          experience. Our chefs craft dishes that blend culture, creativity,
          and care, offering you a culinary journey that delights all senses.
        </p>
      </div>
    </div>
    <section class="special-dishes">
      <h2>Our Special Dishes</h2>
      <div class="dish-container">
        <div class="dish-card">
          <img
            src="./images/Dishes/Indian/Butter Chicken/pre-prepared-food-showcasing-ready-eat-delicious-meals-go.jpg"
            alt="Butter Chicken" />
          <h3 class="Spice_Garden">Butter Chicken</h3>
          <p>Creamy, rich, and packed with authentic North Indian spices.</p>
          <!-- <a href="butter-chicken.html">View Details</a> -->
        </div>

        <div class="dish-card">
          <img
            src="./images/Dishes/Chinese/Hakka Noodles/top-view-delicious-noodles-concept.jpg"
            alt="Hakka Noodles" />
          <h3 class="Spice_Garden">Hakka Noodles</h3>
          <p>
            Perfectly stir-fried noodles bursting with Indo-Chinese flavor.
          </p>
          <!-- <a href="hakka-noodles.html">View Details</a> -->
        </div>

        <div class="dish-card">
          <img
            src="./images/Dishes/Indian/Paneer Tikka/chicken-skewers-with-slices-apples-chili.jpg"
            alt="Paneer Tikka" />
          <h3 class="Spice_Garden">Paneer Tikka</h3>
          <p>Grilled cottage cheese cubes marinated in spiced yogurt.</p>
          <!-- <a href="paneer-tikka.html">View Details</a> -->
        </div>

        <div class="dish-card">
          <img
            src="./images/Dishes/Indian/Hyderabadi Biryani/gourmet-chicken-biryani-with-steamed-basmati-rice-generated-by-ai.jpg "
            alt="Biryani" />
          <h3 class="Spice_Garden">Hyderabadi Biryani</h3>
          <p>Fragrant rice layered with juicy meat and bold spices.</p>
          <!-- <a href="biryani.html">View Details</a> -->
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>&copy; 2025 Spice Garden. All Rights Reserved.</footer>
</body>

</html>