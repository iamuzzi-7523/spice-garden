<?php
require("config.php");
require("session_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST["email"];
  $password = $_POST["password"];

  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);

  if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($password, $row['password'])) {

      // Generate a new session ID after successful authentication
      session_regenerate_id(true);

      $_SESSION['username'] = $row['username'];

      header("Location: index.php");
      exit();
    } else {
      $error = "Incorrect Password!";
    }
  } else {
    $error = "User not found!";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login | Spice Garden</title>

  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      background-color: #f5f5f5;
      font-family: "Poppins", sans-serif;
    }

    .container {
      display: flex;
      width: 80%;
      max-width: 1000px;
      height: 600px;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.3);
      background: rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(8px);
    }

    .image-side {
      flex: 1;
      background: url("./images/Chef's/Gemini_Generated_Image_ikjvq3ikjvq3ikjv.png") center/cover no-repeat;
    }

    .form-side {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 40px;
      background: rgba(255, 255, 255, 0.6);
      backdrop-filter: blur(10px);
    }

    .form-side h1 {
      color: orange;
      font-size: 2.5rem;
      font-family: "Permanent Marker", cursive;
      margin-bottom: 25px;
    }

    form {
      width: 100%;
      max-width: 350px;
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    input {
      padding: 12px 15px;
      border: 1px solid #aaa;
      border-radius: 25px;
      font-size: 1rem;
      width: 100%;
      outline: none;
      background-color: rgba(255, 255, 255, 0.8);
      transition: all 0.3s ease;
    }

    input:focus {
      border-color: black;
      background-color: white;
    }

    /* Show/Hide wrapper */
    .password-wrapper {
      position: relative;
    }

    .password-wrapper input {
      width: 100%;
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 0.9rem;
      color: #333;
      user-select: none;
    }

    button {
      background: #090909;
      color: #f9f5f5;
      padding: 12px 0;
      border-radius: 25px;
      font-weight: 600;
      font-size: 1rem;
      border: none;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    button:hover {
      background: rgb(248, 246, 246);
      color: rgb(12, 12, 12);
      border: 1px solid black;
      transform: scale(1.03);
    }

    .signup-text {
      margin-top: 20px;
      font-size: 0.95rem;
      color: #111;
    }

    .signup-text a {
      color: black;
      font-weight: bold;
      text-decoration: none;
      border-bottom: 1px solid transparent;
      transition: all 0.3s ease;
    }

    .signup-text a:hover {
      border-bottom: 1px solid black;
    }

    .error {
      color: red;
      margin-bottom: 10px;
      font-size: 0.9rem;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">

    <div class="image-side"></div>

    <div class="form-side">
      <h1>Login</h1>

      <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

      <form method="POST" action="">
        <input type="email" name="email" placeholder="Enter Email" required />

        <div class="password-wrapper">
          <input type="password" id="loginPassword" name="password" placeholder="Enter Password" required />
          <span class="toggle-password" onclick="togglePassword('loginPassword', this)">Show</span>
        </div>

        <button type="submit">Login</button>
      </form>

      <p class="signup-text">
        New User? <a href="SignUp.php">Sign Up</a>
      </p>
    </div>
  </div>

  <script>
    function togglePassword(id, element) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        element.innerText = "Hide";
      } else {
        input.type = "password";
        element.innerText = "Show";
      }
    }
  </script>
</body>

</html>