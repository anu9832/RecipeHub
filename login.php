<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
      header('location:index.php');
   }else{
      $message[] = 'incorrect username or password!';
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
  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/img5.jpg">
  <link rel="preload" as="image" href="./assets/images/img21.jpg">
  <link rel="preload" as="image" href="./assets/images/img3.avif">

</head>
<body id="top">

  <!-- 
    - #PRELOADER
  -->

  <div class="preload" data-preaload>
    <div class="circle"></div>
    <p class="text">Recipe Hub</p>
  </div>

  <!-- 
    - #TOP BAR
  -->

  <div class="topbar">
    <div class="container">
      <address class="topbar-item">
        <div class="icon">
          <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">
          Recipe Hub, Chandni Chowk, Delhi – 110006 
        </span>
      </address>
      <div class="separator"></div>
      <div class="topbar-item item-2">
        <div class="icon">
          <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">Daily : 8.00 am to 11.30 pm</span>
      </div>
      <a href="tel:+91 67899 12345" class="topbar-item link">
        <div class="icon">
          <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">+91 67899 12345</span>
      </a>
      <div class="separator"></div>
      <a href="mailto:contact@recipehubdelhi.com" class="topbar-item link">
        <div class="icon">
          <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">contact@recipehubdelhi.com</span>
      </a>
    </div>
  </div>
<!-- Top bar and header -->
<?php include 'components/user_header.php'; ?>
<!-- Login Section -->
<section class="section text-center" aria-label="login"
  style="padding-block: 100px 60px; margin-top: 100px; background-color: var(--eerie-black); position: relative; z-index: 1;">
  <div class="container" style="max-width: 500px; margin-inline: auto; background-color: var(--smoky-black-2); padding: 30px; border-radius: 15px; border: 1px solid var(--gold-crayola);">

    <h2 class="headline-1 section-title" style="color: var(--gold-crayola); margin-bottom: 20px;">Login Now</h2>

    <?php
    if (!empty($message)) {
      echo '<div style="background-color: #ffe0e0; color: #c0392b; padding: 12px 18px; border-left: 5px solid #e74c3c; border-radius: 6px; margin-bottom: 20px; font-weight: bold;">';
      foreach ((array)$message as $msg) {
        echo '<p style="margin: 0;">' . $msg . '</p>';
      }
      echo '</div>';
    }
    ?>

    <form action="" method="post" style="position: relative; z-index: 10;">
      
      <!-- Email Field -->
      <div style="margin-bottom: 20px;">
        <input 
          type="email" 
          name="email" 
          required 
          placeholder="Enter your email" 
          maxlength="50"
          style="width: 100%; padding: 14px 18px; border-radius: 8px; border: none; background-color: var(--smoky-black); color: var(--white); font-size: 16px;"
        >
      </div>

      <!-- Password Field with Toggle -->
      <div style="margin-bottom: 20px; position: relative;">
        <input 
          type="password" 
          name="pass" 
          id="passwordInput" 
          required 
          placeholder="Enter your password" 
          maxlength="50"
          style="width: 100%; padding: 14px 18px 14px 18px; padding-right: 45px; border-radius: 8px; border: none; background-color: var(--smoky-black); color: var(--white); font-size: 16px;"
        >
        <span 
          id="togglePassword" 
          style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: var(--white); cursor: pointer; font-size: 16px;">
          <i class="fa-solid fa-eye"></i>
        </span>
      </div>

      <!-- Submit Button -->
      <input 
        type="submit" 
        name="submit" 
        value="Login Now" 
        style="background-color: var(--gold-crayola); color: var(--black); padding: 12px 30px; border-radius: 8px; border: none; font-weight: bold; cursor: pointer; font-size: 16px; width: 100%; margin-bottom: 15px;"
      >

      <!-- Forgot Password Link -->
 <div style="max-width: 400px; margin: 20px auto; color: #eee; font-weight: 600; font-family: Arial, sans-serif; line-height: 1.4;">

  <p style="margin: 0 0 15px 0;">
    Don't have an account? 
    <a href="register.php" 
       style="display: inline-block; padding: 10px 14px; background-color:rgb(23, 225, 222); /* orange/gold */
              color: #000; border-radius: 6px; text-decoration: none; font-weight: bold;
              font-size: 1.4rem; box-shadow: 0 2px 6px rgba(0,0,0,0.7); cursor: pointer;">
      Register now
    </a>
  </p>

  <p style="margin: 0 0 15px 0;">
    Forgot password? 
    <a href="forgot_password.php" 
       style="display: inline-block; padding: 10px 14px; background-color:#9999ff; /* dark red */
              color: #000; border-radius: 6px; text-decoration: none; font-weight: bold;
              font-size: 1.4rem; box-shadow: 0 2px 6px rgba(0,0,0,0.7); cursor: pointer;">
      Reset here
    </a>
  </p>

  <p style="margin: 0;">
    Are you an admin? 
    <a href="admin/admin_login.php" 
       style="display: inline-block; padding: 10px 14px; background-color:#ff99cc; /* dark green */
              color: #000; border-radius: 6px; text-decoration: none; font-weight: bold;
              font-size: 1.4rem; box-shadow: 0 2px 6px rgba(0,0,0,0.7); cursor: pointer;">
      Login here
    </a>
  </p>

</div>

    </form>
  </div>
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
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>


<script>
  const togglePassword = document.querySelector("#togglePassword");
  const passwordInput = document.querySelector("#passwordInput");

  togglePassword.addEventListener("click", function () {
    const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
    passwordInput.setAttribute("type", type);
    this.innerHTML = type === "password" 
      ? '<i class="fa-solid fa-eye"></i>' 
      : '<i class="fa-solid fa-eye-slash"></i>';
  });
</script>

</body>
</html>
