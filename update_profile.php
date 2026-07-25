<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
   exit;
};

// Fetch current profile to show placeholders
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

$message = [];
if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);

   $number = $_POST['number'];
   $number = preg_replace('/\D/', '', $number); // strip non-digit chars

   if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
       $message[] = 'Invalid email format!';
   } else {

       if(!empty($name)){
          $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
          $update_name->execute([$name, $user_id]);
       }

       if(!empty($email)){
          $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND id != ?");
          $select_email->execute([$email, $user_id]);
          if($select_email->rowCount() > 0){
             $message[] = 'Email already taken!';
          }else{
             $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
             $update_email->execute([$email, $user_id]);
          }
       }

       if(!empty($number)){
          if(strlen($number) != 10){
              $message[] = 'Number must be exactly 10 digits!';
          } else {
              $select_number = $conn->prepare("SELECT * FROM `users` WHERE number = ? AND id != ?");
              $select_number->execute([$number, $user_id]);
              if($select_number->rowCount() > 0){
                 $message[] = 'Number already taken!';
              } else {
                 $update_number = $conn->prepare("UPDATE `users` SET number = ? WHERE id = ?");
                 $update_number->execute([$number, $user_id]);
              }
          }
       }
       
       if(empty($message)) {
    // Set success message in session
    $_SESSION['success_message'] = 'Profile updated successfully!';
    // Redirect to home page
    header('Location: index.php');
    exit;
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

  <!-- header section starts  -->
  <?php include 'components/user_header.php'; ?>
  <!-- header section ends -->

<section
  class="section"
  style="
    margin-top: 200px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    background-color: var(--eerie-black);
    padding: 40px 50px;
    border-radius: 15px;
    border: 1px solid var(--gold-crayola);
  "
>
  
      <h2 class="headline-1 text-center" style="color: var(--gold-crayola); margin-bottom: 30px;">Update Profile</h2>



  <?php if (!empty($message)) : ?>
    <div
      style="
        margin-bottom: 25px;
        padding: 15px 20px;
        background-color: var(--smoky-black-2);
        color: var(--gold-crayola);
        border-radius: 10px;
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.4;
      "
    >
      <?php foreach ($message as $msg) : ?>
        <p style="margin: 8px 0;"><?= htmlspecialchars($msg); ?></p>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <form action="" method="post" style="display: flex; flex-direction: column; gap: 20px;">
    <input
      type="text"
      name="name"
      placeholder="<?= htmlspecialchars($fetch_profile['name']); ?>"
      maxlength="50"
      class="input-field"
      style="
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid var(--gold-crayola);
        background-color: var(--eerie-black);
        color: var(--gold-crayola);
        font-size: 1.3rem;
        font-weight: 600;
        transition: border-color 0.3s ease;
      "
      onfocus="this.style.borderColor='#fff27b'"
      onblur="this.style.borderColor='var(--gold-crayola)'"
    />

    <input
      type="email"
      name="email"
      placeholder="<?= htmlspecialchars($fetch_profile['email']); ?>"
      maxlength="50"
      oninput="this.value = this.value.replace(/\s/g, '')"
      class="input-field"
      style="
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid var(--gold-crayola);
        background-color: var(--eerie-black);
        color: var(--gold-crayola);
        font-size: 1.3rem;
        font-weight: 600;
        transition: border-color 0.3s ease;
      "
      onfocus="this.style.borderColor='#fff27b'"
      onblur="this.style.borderColor='var(--gold-crayola)'"
    />

    <input
      type="text"
      name="number"
      placeholder="<?= htmlspecialchars($fetch_profile['number']); ?>"
      maxlength="10"
      pattern="\d{10}"
      title="Please enter exactly 10 digits"
      oninput="this.value=this.value.replace(/[^0-9]/g,'')"
      class="input-field"
      style="
        width: 100%;
        padding: 16px 20px;
        border-radius: 12px;
        border: 2px solid var(--gold-crayola);
        background-color: var(--eerie-black);
        color: var(--gold-crayola);
        font-size: 1.3rem;
        font-weight: 600;
        transition: border-color 0.3s ease;
      "
      onfocus="this.style.borderColor='#fff27b'"
      onblur="this.style.borderColor='var(--gold-crayola)'"
    />

    <a
      href="forgot_password.php"
      style="
        width: 40%;
        padding: 10px 0;
        background-color: #6666ff;
        color: #fff;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 1.4rem;
        text-align: center;
        align-self: center;
        transition: background-color 0.3s ease;
      "
      onmouseover="this.style.backgroundColor='#7f7fff'"
      onmouseout="this.style.backgroundColor='#6666ff'"
    >
      Reset Password here
    </a>

    <input
      type="submit"
      name="submit"
      value="Update Now"
      class="btn btn-primary"
      style="
        width: 200px;
        padding: 16px 10px;
        font-weight: 700;
        font-size: 1.4rem;
        background-color: var(--gold-crayola);
        border: none;
        border-radius: 12px;
        color: var(--black);
        cursor: pointer;
        align-self: center;
        transition: background-color 0.3s ease;
      "
      onmouseover="this.style.backgroundColor='#fff27b'"
      onmouseout="this.style.backgroundColor='var(--gold-crayola)'"
    />
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
 <!-- SCRIPT -->
<script src="./assets/js/script.js"></script>

<!-- IONICONS -->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>
