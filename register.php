<?php
include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
} else {
  $user_id = '';
}

if (isset($_POST['submit'])) {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
  $number = filter_var($_POST['number'], FILTER_SANITIZE_STRING);
  $pass = sha1(filter_var($_POST['pass'], FILTER_SANITIZE_STRING));
  $cpass = sha1(filter_var($_POST['cpass'], FILTER_SANITIZE_STRING));

  $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR number = ?");
  $select_user->execute([$email, $number]);

  if ($select_user->rowCount() > 0) {
    $message[] = 'Email or number already exists!';
  } else {
    if ($pass !== $cpass) {
      $message[] = 'Confirm password not matched!';
    } else {
      $insert_user = $conn->prepare("INSERT INTO `users`(name, email, number, password) VALUES(?, ?, ?, ?)");
      $insert_user->execute([$name, $email, $number, $cpass]);

      $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
      $select_user->execute([$email, $pass]);
      $row = $select_user->fetch(PDO::FETCH_ASSOC);

      if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        header('location:index.php');
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- 
    - primary meta tags
  -->
  <title>Recipe Hub - Cravings Met, Taste Elevated!</title>
  <meta name="title" content="Recipe Hub - Cravings Met, Taste Elevated!">
  <meta name="description" content="This is a Restaurant html template made by anushuya">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./fav1.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body id="top">

<!-- PRELOADER -->
<div class="preload" data-preaload>
  <div class="circle"></div>
  <p class="text">Recipe Hub</p>
</div>

<!-- TOPBAR -->
<div class="topbar">
  <div class="container">
    <address class="topbar-item">
      <div class="icon"><ion-icon name="location-outline" aria-hidden="true"></ion-icon></div>
      <span class="span"> Recipe Hub, Chandni Chowk, Delhi – 110006</span>
    </address>

    <div class="separator"></div>

    <div class="topbar-item item-2">
      <div class="icon"><ion-icon name="time-outline" aria-hidden="true"></ion-icon></div>
      <span class="span">Daily : 8.00 am to 10.00 pm</span>
    </div>

    <a href="tel:++91 67899 12345" class="topbar-item link">
      <div class="icon"><ion-icon name="call-outline" aria-hidden="true"></ion-icon></div>
      <span class="span">+91 67899 12345</span>
    </a>

    <div class="separator"></div>

    <a href="mailto:contact@recipehubdelhi.com" class="topbar-item link">
      <div class="icon"><ion-icon name="mail-outline" aria-hidden="true"></ion-icon></div>
      <span class="span">contact@recipehubdelhi.com</span>
    </a>
  </div>
</div>

<!-- HEADER -->
<?php include 'components/user_header.php'; ?>

<!-- Grilli-Styled Register Form -->
<section class="section form-section text-center" aria-label="register" style="padding-block: 60px; background-color: var(--eerie-black); margin-top: 140px;">

  <div class="container" style="max-width: 600px; margin-inline: auto; background-color: var(--smoky-black-2); padding: 40px 30px; border-radius: 15px; border: 1px solid var(--gold-crayola);">

    <h2 class="headline-1 section-title" style="color: var(--gold-crayola); margin-bottom: 25px;">Register Now</h2>

  <form action="" method="post" onsubmit="return validateForm()">

  <!-- NAME -->
  <div class="input-wrapper" style="margin-bottom: 20px;">
    <input type="text" name="name" required placeholder="Enter your name" maxlength="50"
      class="input-field"
      style="width: 100%; padding: 12px 16px; border-radius: 8px; background-color: var(--smoky-black); color: var(--white); border: none;">
  </div>

  <!-- EMAIL -->
  <div class="input-wrapper" style="margin-bottom: 20px;">
    <input type="email" id="email" name="email" required placeholder="Enter your email" maxlength="50"
      oninput="this.value = this.value.replace(/\s/g, '')"
      class="input-field"
      style="width: 100%; padding: 12px 16px; border-radius: 8px; background-color: var(--smoky-black); color: var(--white); border: none;">
  </div>

  <!-- PHONE NUMBER -->
  <div class="input-wrapper" style="margin-bottom: 20px;">
    <input type="tel" name="number" id="number" required placeholder="Enter your number"
      pattern="\d{10}" title="Please enter a 10-digit phone number" maxlength="10"
      class="input-field"
      style="width: 100%; padding: 12px 16px; border-radius: 8px; background-color: var(--smoky-black); color: var(--white); border: none;">
  </div>

  <!-- PASSWORD -->
  <div class="input-wrapper" style="margin-bottom: 20px; position: relative;">
    <input type="password" name="pass" id="pass" required placeholder="Enter your password" maxlength="50"
      oninput="this.value = this.value.replace(/\s/g, '')"
      class="input-field"
      style="width: 100%; padding: 12px 40px 12px 16px; border-radius: 8px; background-color: var(--smoky-black); color: var(--white); border: none;">
    <i class="fa fa-eye" onclick="togglePassword('pass')" style="position: absolute; right: 12px; top: 14px; color: white; cursor: pointer;"></i>
  </div>

  <!-- CONFIRM PASSWORD -->
  <div class="input-wrapper" style="margin-bottom: 20px; position: relative;">
    <input type="password" name="cpass" id="cpass" required placeholder="Confirm your password" maxlength="50"
      oninput="this.value = this.value.replace(/\s/g, '')"
      class="input-field"
      style="width: 100%; padding: 12px 40px 12px 16px; border-radius: 8px; background-color: var(--smoky-black); color: var(--white); border: none;">
    <i class="fa fa-eye" onclick="togglePassword('cpass')" style="position: absolute; right: 12px; top: 14px; color: white; cursor: pointer;"></i>
  </div>

  <input type="submit" value="Register Now" name="submit"
    class="btn"
    style="background-color: var(--gold-crayola); color: var(--black); padding: 12px 30px; border-radius: 8px; border: none; cursor: pointer; margin-bottom: 20px;">

  <p style="color: var(--white);">Already have an account? 
    <a href="login.php" style="color: var(--gold-crayola); text-decoration: underline;">Login now</a>
  </p>
</form>
</section>
  <footer class="footer section has-bg-image text-center"
    style="background-image: url('./assets/images/footer-bg.jpg')">
    <div class="container">

      <div class="footer-top grid-list">

        <div class="footer-brand has-before has-after">

          <a href="#" class="logo">
            <img src="./assets/images/logo 1.png" width="200" height="200" loading="lazy" alt="crave haven home">
          </a>

          <address class="body-4">
           Recipe Hub, Chandni Chowk, Delhi – 110006 
          </address>

          <a href="mailto:contact@recipehubdelhi.com" class="body-4 contact-link">contact@recipehubdelhi.com</a>

          <a href="tel:+91 67899 12345" class="body-4 contact-link">Booking Request : +91 67899 12345</a>

          <p class="body-4">
            Open : 08:00 am - 11:30 pm
          </p>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>
        </div>
        <ul class="footer-list">

          <li>
            <a href="index.php" class="label-2 footer-link hover-underline">Home</a>
          </li>

          <li>
            <a href="menu.php" class="label-2 footer-link hover-underline">Menus</a>
          </li>

          <li>
            <a href="index.php#about" class="label-2 footer-link hover-underline">About Us</a>
          </li>
          
          <li>
            <a href="index.php#reservation" class="label-2 footer-link hover-underline">Contact</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Facebook</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Instagram</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Twitter</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Youtube</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Google Map</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <p class="copyright">
          &copy; 2025 Recipe Hub. All Rights Reserved | Designed with flavor, crafted with care <a href="https://github.com/anu9832"
            target="_blank" class="link">Anushuya</a>
        </p>

      </div>

    </div>
  </footer>
  <!-- 
    - #BACK TO TOP
  -->
  <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>
<script>
function togglePassword(id) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
}

function validateForm() {
  const phone = document.getElementById("number").value;
  if (phone.length !== 10 || isNaN(phone)) {
    alert("Phone number must be exactly 10 digits.");
    return false;
  }

  const password = document.getElementById("pass").value;
  const confirmPassword = document.getElementById("cpass").value;

  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
  if (!passwordRegex.test(password)) {
    alert("Password must be at least 8 characters long, include uppercase, lowercase, a digit, and a special character.");
    return false;
  }

  if (password !== confirmPassword) {
    alert("Passwords do not match.");
    return false;
  }

  const email = document.getElementById("email").value;
  const emailRegex = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
  if (!emailRegex.test(email)) {
    alert("Please enter a valid email address.");
    return false;
  }

  return true;
}
</script>

  </div>
</section>



<!-- SCRIPT -->
<script src="./assets/js/script.js"></script>

<!-- IONICONS -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>
