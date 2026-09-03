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
    main {
      padding: 40px;
      margin: 30px;
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(8px);
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
      font-family: Arial, Helvetica, sans-serif;
      color: #111;
    }

    .category-tabs {
      /* ===== Secondary NavBar ===== */
      position: sticky;
      top: 60px;
      /* sits below your main site header */
      display: flex;
      justify-content: center;
      gap: 20px;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
      padding: 12px 0;
      border-radius: 12px;
      z-index: 50;
      transition: transform 0.4s ease, opacity 0.4s ease;
    }

    .category-tabs a {
      text-decoration: none;
      color: rgb(251, 250, 250);
      background-color: #000;
      font-weight: bold;
      padding: 8px 20px;
      border-radius: 25px;
      transition: all 0.3s ease;
      border: 1px solid black;
    }

    .category-tabs a:hover {
      background: rgb(252, 252, 252);
      color: rgb(10, 10, 10);
      transform: scale(1.05);
    }

    .category-tabs.hidden {
      /* Hidden state (applied when scrolling down) */
      transform: translateY(-120%);
      opacity: 0;
    }

    section {
      /* ===== Section Titles ===== */
      margin-bottom: 80px;
      scroll-margin-top: 100px;
    }

    section h2 {
      font-size: 2rem;
      text-align: center;
      margin-bottom: 40px;
      color: #000;
      text-transform: uppercase;
    }

    .dish {
      /* ===== Dish Layout ===== */
      display: flex;
      align-items: flex-start;
      justify-content: center;
      gap: 40px;
      margin-bottom: 60px;
      flex-wrap: wrap;
    }

    .dish img {
      width: 360px;
      height: auto;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease;
    }

    .dish .img1 {
      width: 360px;
      height: auto;
      border-radius: 0px !important;
      box-shadow: none !important;
      transition: transform 0.3s ease;
    }

    .dish img:hover {
      transform: scale(1.03);
    }

    .dish-info {
      max-width: 450px;
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
      height: auto;
      box-sizing: border-box;
      word-wrap: break-word;
    }

    .dish-info h3 {
      color: orange;
      font-size: 1.6rem;
      margin-bottom: 10px;
    }

    .dish-info p {
      color: #111;
      line-height: 1.6;
      font-size: 1.05rem;
      margin-bottom: 4px;
    }

    .dish-info li {
      color: #111;
      line-height: 1.6;
      font-size: 1.05rem;
      margin-left: 10px;
    }

    .dish-info h4 {
      line-height: 1.6;
      font-size: 1.2rem;
      margin-bottom: 4px;
    }

    .dish:nth-child(even) {
      /* ===== Alternate Layout (image left/right) ===== */
      flex-direction: row-reverse;
    }

    @media (max-width: 768px) {
      .dish {
        flex-direction: column !important;
        text-align: center;
      }

      .dish-info {
        max-width: 90%;
      }
    }

    .flip-card {
      /* FLIP-CARD (left card flips to details) */
      width: 450px;
      /* match your image width */
      aspect-ratio: 450 / 540;
      /*keeps card tall-ish; adjust if needed*/
      perspective: 1000px;
      border-radius: 20px;
      overflow: visible;
      flex: 0 0 auto;
    }

    .flip-card .card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transform-style: preserve-3d;
      transition: transform 0.7s cubic-bezier(0.2, 0.9, 0.3, 1);
      border-radius: 20px;
    }

    /* flip on hover/focus or when .flipped class is present (used by JS) */
    .flip-card:hover .card-inner,
    .flip-card:focus-within .card-inner,
    .flip-card.flipped .card-inner {
      transform: rotateY(180deg);
    }

    .flip-card .card-face {
      /* faces */
      position: absolute;
      inset: 0;
      backface-visibility: hidden;
      -webkit-backface-visibility: hidden;
      border-radius: 20px;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .flip-card .front img {
      /* border-radius: 20px; */
      width: 100%;
      height: auto;
    }

    .flip-card .front {
      /* FRONT: image + title overlay (visible initially) */
      position: absolute;
      /* left: 12px;
        right: 12px;
        bottom: 12px; */
      /* background: rgba(0, 0, 0, 0.55); */
      /* color: #fff; */
      /* padding: 8px 12px; */
      border-radius: 10px;
      font-weight: 700;
      text-align: center;
      font-size: 1.05rem;
      display: block;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
      max-width: 450px;
      background: rgba(255, 255, 255, 0.3);
      backdrop-filter: blur(6px);
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
      height: auto;
      box-sizing: border-box;
      word-wrap: break-word;
    }

    .flip-card .front h3 {
      color: orange;
      font-size: 1.4rem;
      margin-bottom: 10px;
      /* background: rgba(0, 0, 0, 0.55); */
      /* padding: 8px 12px; */
      /* border-radius: 10px; */
    }

    .flip-card .back {
      /* BACK: details card (rotated so it faces forward after flip) */
      transform: rotateY(180deg);
      background: rgba(255, 255, 255, 0.95);
      color: #111;
      padding: 18px;
      box-sizing: border-box;
      text-align: left;
      overflow: auto;
    }

    @media (max-width: 768px) {

      /* responsive tweak */
      .flip-card {
        width: 90%;
        aspect-ratio: auto;
      }

      .dish {
        flex-direction: column !important;
        gap: 20px;
      }

      .dish-info {
        width: 100%;
        max-width: none;
      }
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


  <main>
    <div class="category-tabs" id="categoryTabs">
      <a href="#indian">Indian</a>
      <a href="#italian">Italian</a>
      <a href="#chinese">Chinese</a>
      <a href="#desserts">Desserts</a>
    </div>

    <section id="indian">
      <h2 class="Spice_Garden">Indian Dishes</h2>
      <div class="dish">
        <img
          src="./images/Dishes/Indian/Buttery Naan/Soft & Fluffy Naan Bread Recipe – Perfect for Any Meal! 🍞🔥.jpg"
          alt="Buttery Naan" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="1">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Buttery Naan</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_1/Chef_12.png"
                alt="Image of Chef" />
              <h4>Place Cursor over here to know more about Dish</h4>
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h2 class="Spice_Garden">Buttery Naan</h2>
                <p>
                  A classic Indian flatbread, baked fresh in our tandoor until
                  perfectly soft and pillowy.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Refined flour</li>
                  <li>Yogurt</li>
                  <li>Butter</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Butter Naan" />
                  <input type="hidden" name="price" value="70" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Hyderabadi Biryani/Chicken 65 Biryani Recipe Gives The Authentic___.jpg"
          alt="Hyderabadi Biryani" />
        <div class="flip-card" tabindex="2">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Hyderabadi Biryani</h2>
              <img
                class="img1"
                src="./images/Dishes/Indian/Hyderabadi Biryani/Gemini_Generated_Image_ydx17wydx17wydx1 (1) (1).png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Hyderabadi Biryani</h3>
                <p>
                  An iconic dish where fragrant Basmati rice and tender
                  marinated meat are layered and slow-cooked to perfection in
                  the traditional 'dum' style.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Basmati rice</li>
                  <li>Ghicken/Lamb</li>
                  <li>Yogurt</li>
                  <li>Saffron</li>
                  <li>Mint</li>
                  <li>Fried onions</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Hyderabadi Biryani" />
                  <input type="hidden" name="price" value="349" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Chicken Tandoori/Tandoori Chicken.jpg"
          alt="Chicken Tandoori" />
        <div class="flip-card" tabindex="3">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Chicken Tandoori</h2>
              <img
                class="img1"
                src="./images/Dishes/Indian/Chicken Tandoori/Gemini_Generated_Image_jnozmzjnozmzjnoz (1).png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h2 class="Spice_Garden">Chicken Tandoori</h2>
                <p>
                  A timeless classic where succulent chicken is marinated in a
                  vibrant blend of yogurt, ginger, garlic, and aromatic
                  spices.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>

                <ul>
                  <li>Chicken</li>
                  <li>Ginger-garlic paste</li>
                  <li>Yogurt</li>
                  <li>Tandoori spices</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Chicken Tandoori" />
                  <input type="hidden" name="price" value="299" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Butter Chicken/pre-prepared-food-showcasing-ready-eat-delicious-meals-go.jpg"
          alt="Butter Chicken" />
        <div class="flip-card" tabindex="4">
          <div class="card-inner">
            <div
              class="card-face front"
              style="
                  margin-top: 0px !important;
                  padding: 0px 25px 25px 25px !important;
                  overflow: hidden !important;
                ">
              <img
                class="img1"
                src="./images/Dishes/Indian/Butter Chicken/img1.png"
                alt="Image of Chef" />
              <h2 class="Spice_Garden">Butter Chicken</h2>
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h2 class="Spice_Garden">Butter Chicken</h2>

                <p>
                  A world-famous dish featuring tender, chargrilled chicken
                  pieces simmered in a velvety, rich gravy of tomatoes and
                  butter.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Tandoori chicken</li>
                  <li>Tomatoes</li>
                  <li>Cream</li>
                  <li>Fenugreek</li>
                  <li>Butter</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Butter Chicken" />
                  <input type="hidden" name="price" value="299" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Samosa/SAMOSA INDIA.jpg"
          alt="Samosa" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="3">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Samosa</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_1/Chef_15.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Samosa</h3>
                <p>
                  A quintessential Indian snack featuring a golden, flaky
                  pastry stuffed with a warm, savory filling of spiced
                  potatoes and tender green peas.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Potatoes</li>
                  <li>Green peas</li>
                  <li>All-purpose flour pastry</li>
                  <li>Mixed Indian spices</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Samosa" />
                  <input type="hidden" name="price" value="25" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Chole Bhature/Chole Bhature.jpg"
          alt="Chole Bhature" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="4">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Chole Bhature</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_1/Chef_11.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Chole Bhature</h3>
                <p>
                  The ultimate North Indian comfort food, this dish pairs a
                  robust, slow-cooked chickpea curry with two large, freshly
                  fried breads.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Chickpeas</li>
                  <li>Onion-tomato gravy</li>
                  <li>Mixed spices</li>
                  <li>Leavened refined flour (for bhature)</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Chole Bhature" />
                  <input type="hidden" name="price" value="120" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Paneer Tikka/Chicken Yakitori Skewers_ Your New Go-To Weeknight Hero - Eat Fine Food.jpg"
          alt="Paneer Tikka" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="5">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Paneer Tikka</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Dishes/Indian/Paneer Tikka/img1 (1).png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Paneer Tikka</h3>
                <p>
                  Succulent cubes of fresh paneer are marinated in a rich,
                  tangy blend of yogurt and aromatic spices, then skewered
                  with crisp bell peppers and onions.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Paneer (Indian cottage cheese)</li>
                  <li>Yogurt</li>
                  <li>Bell peppers</li>
                  <li>Onions</li>
                  <li>Tikka spices</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Paneer Tikka" />
                  <input type="hidden" name="price" value="199" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Rogan josh/Delicious Rogan Josh Recipe.jpg"
          alt="Rogan Josh" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="6">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Rogan Josh</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_1/Chef_13.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Rogan Josh</h3>
                <p>
                  An iconic Kashmiri masterpiece, this dish features
                  fall-off-the-bone lamb slow-cooked in a vibrant and aromatic
                  red gravy.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Lamb</li>
                  <li>Yogurt</li>
                  <li>Kashmiri Red Chilies</li>
                  <li>Fennel</li>
                  <li>Aromatic spices</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Rogan Josh" />
                  <input type="hidden" name="price" value="379" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Indian/Pav Bhaji/pav bhaji 😋😍😋.jpg"
          alt="Pav Bhaji" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="7">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Pav Bhaji</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_1/Chef_14.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Pav Bhaji</h3>
                <p>
                  A beloved Mumbai street food classic, this dish is a
                  flavorful medley of mashed vegetables simmered in a special
                  blend of spices and served with soft, buttery toasted rolls
                  (pav).
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Mixed Vegetables (Potatoes, Peas, Tomatoes)</li>
                  <li>YogOnionsurt</li>
                  <li>Ginger-Garlic Paste</li>
                  <li>Pav Bhaji Masala</li>
                  <li>Butter</li>
                  <li>Bread Rolls (Pav)</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Pav Bhaji" />
                  <input type="hidden" name="price" value="110" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Italian Cuisine -->
    <section id="italian">
      <h2 class="Spice_Garden">Italian Dishes</h2>
      <div class="dish">
        <img
          src="./images/Dishes/Italian/Lasagna/Homemade Lasagna with Meat Sauce.jpg"
          alt="Lasagna" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="8">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Lasagna</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_3/Chef_32.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Lasagna</h3>
                <p>
                  A timeless Italian classic, our Lasagna features delicate
                  layers of fresh pasta alternating with a hearty,
                  slow-simmered beef ragù and a creamy béchamel sauce.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Lasagna Pasta</li>
                  <li>Ground Beef</li>
                  <li>Tomato Sauce</li>
                  <li>Béchamel Sauce</li>
                  <li>Mozzarella</li>
                  <li>Parmesan Cheese</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Lasagna" />
                  <input type="hidden" name="price" value="399" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Italian/Bruschetta/Easy Tomato Bruschetta with Fresh Basil & Garlic.jpg"
          alt="Bruschetta" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="9">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Bruschetta</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_3/Chef_33.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Bruschetta</h3>
                <p>
                  The quintessential Italian starter, featuring slices of
                  rustic bread grilled to crispy perfection and rubbed with
                  fresh garlic.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Toasted Bread</li>
                  <li>Fresh Tomatoes</li>
                  <li>Garlic</li>
                  <li>Basil</li>
                  <li>Extra Virgin Olive Oil</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Bruschetta" />
                  <input type="hidden" name="price" value="149" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Italian/Spaghetti/Spaghetti Bolognese food Photography.jpg"
          alt="Spaghetti " />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="10">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Spaghetti</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_3/Chef_34.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Spaghetti</h3>
                <p>
                  An iconic and comforting classic, featuring perfectly cooked
                  al dente spaghetti tossed in our rich, slow-simmered meat
                  ragù.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Spaghetti Pasta</li>
                  <li>Ground Beef</li>
                  <li>Tomato Sauce</li>
                  <li>BaOnionssil</li>
                  <li>Parmesan Cheese</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Spaghetti" />
                  <input type="hidden" name="price" value="259" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Italian/Pesto Pasta/Creamy Pesto Pasta (30-Minute Meal!).jpg"
          alt="Pesto Pasta " />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="11">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Pesto Pasta</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_3/Chef_35.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Pesto Pasta</h3>
                <p>
                  The rich and aromatic sauce is a classic blend of fresh
                  basil, toasted pine nuts, and aged Parmesan, all brought
                  together with a fine extra virgin olive oil for a simple yet
                  elegant meal.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Pasta</li>
                  <li>Fresh Basil</li>
                  <li>Pine Nuts</li>
                  <li>Parmesan Cheese</li>
                  <li>Garlic</li>
                  <li>Extra Virgin Olive Oil</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Pesto Pasta" />
                  <input type="hidden" name="price" value="319" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Italian/Arancini Rice Ball/Baked Arancini.jpg"
          alt="Arancini Rice Ball" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="12">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Arancini Rice Ball</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_3/Chef_31.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Arancini Rice Ball</h3>
                <p>
                  An irresistible Sicilian specialty, our Arancini are balls
                  of creamy risotto stuffed with a rich beef ragù and melting
                  mozzarella cheese.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Arborio Rice</li>
                  <li>Beef Ragù</li>
                  <li>Mozzarella</li>
                  <li>Peas</li>
                  <li>Breadcrumbs</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Arancini (Rice Balls)" />
                  <input type="hidden" name="price" value="259" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Italian/Caprese Salad/Authentic Caprese Salad  _ Fresh Italian Classic.jpg"
          alt="Caprese Salad" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="13">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Caprese Salad</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_3/Chef_36.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Caprese Salad</h3>
                <p>
                  Slices of soft, creamy mozzarella are layered with
                  succulent, sun-ripened tomatoes and fragrant basil leaves,
                  then finished with a drizzle of the finest extra virgin
                  olive oil.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Fresh Mozzarella</li>
                  <li>Ripe Tomatoes</li>
                  <li>Fresh Basil</li>
                  <li>Extra Virgin Olive Oil</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Caprese Salad" />
                  <input type="hidden" name="price" value="199" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Chinese Cuisine -->
    <section id="chinese">
      <h2 class="Spice_Garden">Chinese Dishes</h2>
      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Spring Rolls/Crispy Vegan Spring Rolls It's crunch time! With these delicious aromatic deep-fried cris.jpg"
          alt="Spring Rolls" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="14">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Spring Rolls</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_41.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Spring Rolls</h3>
                <p>
                  An iconic starter, these delicate rolls are stuffed with a
                  savory medley of fresh, crisp vegetables and seasoned to
                  perfection.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Spring Roll Pastry</li>
                  <li>Mixed Vegetables (Cabbage, Carrots)</li>
                  <li>Soy Sauce</li>
                  <li>Seasonings</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Spring Rolls" />
                  <input type="hidden" name="price" value="129" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Hakka Noodles/Classic Chicken Chow Mein _ How To Make In Easiest Ways!.jpg"
          alt="Hakka Noodles" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="15">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Hakka Noodles</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_4.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Hakka Noodles</h3>
                <p>
                  An all-time favorite, this dish features perfectly cooked
                  noodles wok-tossed over high heat with a crisp medley of
                  julienned cabbage, carrots, and bell peppers.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Noodles</li>
                  <li>Carrots</li>
                  <li>Bell Peppers</li>
                  <li>Soy Sauce</li>
                  <li>Cabbage</li>
                  <li>Garlic</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Hakka Noodles" />
                  <input type="hidden" name="price" value="179" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Mapo Tofu/Mapo Tofu Recipe!.jpg"
          alt="Mapo Tofu" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="16">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Mapo Tofu</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_42.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Mapo Tofu</h3>
                <p>
                  A true icon of Sichuan cuisine, this dish features cubes of
                  delicate, silken tofu bathed in a vibrant, spicy sauce with
                  savory minced pork.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Silken Tofu</li>
                  <li>Minced Pork</li>
                  <li>Chili Bean Paste</li>
                  <li>Sichuan Peppercorns</li>
                  <li>Fermented Black Beans</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Mapo Tofu" />
                  <input type="hidden" name="price" value="249" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Kung Pao Chicken/Kung Pao Chicken.jpg"
          alt="Kung Pao Chicken" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="17">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Kung Pao Chicken</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_43.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Kung Pao Chicken</h3>
                <p>
                  A globally beloved Sichuan classic, this dish is a bold and
                  savory stir-fry of tender diced chicken, roasted peanuts,
                  and fiery dried chilies.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Diced Chicken</li>
                  <li>Peanuts</li>
                  <li>Dried Chilies</li>
                  <li>Bell Peppers</li>
                  <li>Soy Sauce</li>
                  <li>Vinegar</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Kung Pao Chicken" />
                  <input type="hidden" name="price" value="299" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Dumpling/Crispy Pan-Fried Chicken Dumplings Recipe _ Tasty Meals Blog.jpg"
          alt="Dumpling" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="18">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Dumpling</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_44.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Dumpling</h3>
                <p>
                  A classic comfort food, our handcrafted dumplings are
                  generously filled with a savory and juicy mixture of minced
                  pork, cabbage, and ginger.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Minced Pork</li>
                  <li>Cabbage</li>
                  <li>Ginger</li>
                  <li>Scallions</li>
                  <li>Wheat Wrapper</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Dumplings" />
                  <input type="hidden" name="price" value="159" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Chow Mein/Flavor-Packed Chicken Chow Mein Recipes Everyone Will Love.jpg"
          alt="Chow Mein" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="19">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Chow Mein</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_45.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Chow Mein</h3>
                <p>
                  A quintessential noodle dish, our Chow Mein is a satisfying
                  stir-fry of tender egg noodles, succulent chicken, and a
                  crisp medley of cabbage, carrots, and bean sprouts.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Egg Noodles</li>
                  <li>Chicken</li>
                  <li>Cabbage</li>
                  <li>Carrots</li>
                  <li>Soy Sauce</li>
                  <li>Bean Sprouts</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Chow Mein" />
                  <input type="hidden" name="price" value="169" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Chinese/Dim Sum/Dim Sum Dumplings.jpg"
          alt="Dim Sum" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="20">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Dim Sum</h2>
              <img
                class="img1"
                style="align-items: center"
                src="./images/Chef's/Chef_4/Chef_46.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Dim Sum</h3>
                <p>
                  We offer a delightful assortment of handcrafted, bite-sized
                  treasures, from delicate steamed dumplings to savory buns,
                  each bursting with authentic flavor.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Shrimp Dumplings (Har Gow)</li>
                  <li>Pork & Mushroom Dumplings (Siu Mai)</li>
                  <li>BBQ Pork Buns</li>
                  <li>Spring Rolls</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Dim Sum" />
                  <input type="hidden" name="price" value="279" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Desserts -->
    <section id="desserts">
      <h2 class="Spice_Garden">Pastry & Desserts</h2>
      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Tiramisu/Tiramisu.jpg"
          alt="Tiramisu" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="21">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Tiramisu</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_21.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Tiramisu</h3>
                <p>
                  The quintessential Italian "pick-me-up," this elegant
                  dessert features delicate ladyfinger biscuits soaked in rich
                  espresso and layered with a light, airy cream of sweetened
                  mascarpone.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Mascarpone Cheese</li>
                  <li>Espresso</li>
                  <li>Eggs</li>
                  <li>Cocoa Powder</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Tiramisu" />
                  <input type="hidden" name="price" value="349" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Brownies/download.jpg"
          alt="Brownies" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="22">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Brownies</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_27.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Brownies</h3>
                <p>
                  The ultimate decadent treat, our classic brownie is
                  incredibly rich, fudgy, and moist in the center, with a
                  perfectly crisp, crackly top.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Dark Chocolate</li>
                  <li>Butter</li>
                  <li>Eggs</li>
                  <li>Sugar</li>
                  <li>Flour</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Brownies" />
                  <input type="hidden" name="price" value="149" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Macarons/macaroons.jpg"
          alt="Macarons" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="23">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Macarons</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_23.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Macarons</h3>
                <p>
                  A classic French delicacy, these elegant confections feature
                  two light-as-air almond meringue shells with a delicate,
                  crisp exterior and a delightfully chewy center.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Almond Flour</li>
                  <li>Egg Whites</li>
                  <li>EggGanache (or Buttercream Filling)s</li>
                  <li>Sugar</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Macarons" />
                  <input type="hidden" name="price" value="199" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Pudding/Delicious Keto Leche Flan Recipe for Guilt-Free Indulgence.jpg"
          alt="Pudding" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="24">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Pudding</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_24.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Pudding</h3>
                <p>
                  Served chilled, its luxuriously creamy texture simply melts
                  in your mouth, offering a simple, nostalgic, and incredibly
                  satisfying end to your meal.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Whole Milk</li>
                  <li>Cream</li>
                  <li>Egg</li>
                  <li>Sugar</li>
                  <li>Vanilla Bean</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Pudding" />
                  <input type="hidden" name="price" value="149" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Gulab Jamun/Gulab Jamun Caramelizado _ Postres Indios _ Dulces Navideños _ Recetas Internacionales.jpg"
          alt="Gulab Jamun " />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="25">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Gulab Jamun</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_25.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Gulab Jamun</h3>
                <p>
                  One of India's most beloved desserts, these are soft,
                  melt-in-your-mouth dumplings made from rich milk solids,
                  fried to a perfect golden brown.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Milk Solids (Khoya)</li>
                  <li>Flour</li>
                  <li>Cardamom</li>
                  <li>Sugar</li>
                  <li>Rose Water</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Gulab Jamun" />
                  <input type="hidden" name="price" value="99" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Yue Bing/download.jpg"
          alt="Yue Bing" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="26">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Yue Bing (Mooncake)</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_28.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Yue Bing (Mooncake)</h3>
                <p>
                  This iconic treat features a tender, golden-brown crust that
                  encases a rich, dense filling, most commonly a sweet lotus
                  seed paste. Often, a whole salted duck egg yolk is embedded
                  in the center, representing the moon itself.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Lotus Seed Paste (or Red Bean Paste)</li>
                  <li>Flour</li>
                  <li>Salted Duck Egg Yolk</li>
                  <li>Sugar</li>
                  <li>Oil</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Mooncakes" />
                  <input type="hidden" name="price" value="249" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Cheese Cake/Berries Cheesecake.jpg"
          alt="Cheese Cake" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="27">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Cheese Cake</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_22.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Cheese Cake</h3>
                <p>
                  A timeless and decadent dessert, our classic cheesecake
                  features a rich, velvety-smooth filling made from the finest
                  cream cheese.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Cream Cheese</li>
                  <li>Graham Cracker Crust</li>
                  <li>Eggs</li>
                  <li>Sugar</li>
                  <li>Butter</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Cheesecake" />
                  <input type="hidden" name="price" value="299" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Ma Lai  Gao/Ma Lai Gao _ Chinese Steamed Sponge Cake.jpg"
          alt="Yue Bing" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="28">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Ma Lai Gao (Steamed Sponge Cake)</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_29.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Ma Lai Gao (Steamed Sponge Cake)</h3>
                <p>
                  A beloved classic in Cantonese dim sum, this traditional
                  sponge cake is steamed, not baked, to achieve an incredibly
                  light, fluffy, and moist texture.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Evaporated Milk</li>
                  <li>Eggs</li>
                  <li>Flour</li>
                  <li>Brown Sugar</li>
                  <li>Butter</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Steamed Sponge Cake" />
                  <input type="hidden" name="price" value="99" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="dish">
        <img
          src="./images/Dishes/Pastry and Desserts/Rasmalia/21673b0b-3d1b-49f0-932b-13dd195a2017.jpg"
          alt="Rasmalai" />
        <div
          class="flip-card"
          style="aspect-ratio: 450 / 560 !important"
          tabindex="29">
          <div class="card-inner">
            <div class="card-face front">
              <h2 class="Spice_Garden">Rasmalai</h2>
              <img
                class="img1"
                src="./images/Chef's/Chef_2/Chef_26.png"
                alt="Image of Chef" />
            </div>
            <div class="card-face back">
              <div class="dish-info">
                <h3 class="Spice_Garden">Rasmalai</h3>
                <p>
                  The luscious milk is delicately flavored with aromatic
                  saffron and cardamom, and the entire dish is chilled and
                  garnished with slivered pistachios for a truly elegant
                  finish.
                </p>
                <h4 class="Spice_Garden">Key Ingredients:</h4>
                <ul>
                  <li>Milk</li>
                  <li>Paneer (Cottage Cheese)</li>
                  <li>Cardamom</li>
                  <li>Sugar</li>
                  <li>Saffron</li>
                  <li>Pistachios</li>
                </ul>
                <form action="add_to_cart.php" method="POST">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                  <input type="hidden" name="dish" value="Rasmalai" />
                  <input type="hidden" name="price" value="129" />
                  <button type="submit" class="cta-btn">Add to Table</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer>&copy; 2025 Spice Garden. All Rights Reserved.</footer>

  <script>
    let lastScrollY = window.scrollY;
    const tabs = document.getElementById("categoryTabs");

    window.addEventListener("scroll", () => {
      if (window.scrollY > lastScrollY && window.scrollY > 150) {
        // user is scrolling down → hide tabs
        tabs.classList.add("hidden");
      } else {
        // user scrolling up → show tabs
        tabs.classList.remove("hidden");
      }
      lastScrollY = window.scrollY;
    });
  </script>
</body>

</html>