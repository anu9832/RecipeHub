<?php
session_start();
include 'components/connect.php';

$user_id = $_SESSION['user_id'] ?? null;

if ($user_id) {
   $select_profile = $conn->prepare("SELECT * FROM users WHERE id = ?");
   $select_profile->execute([$user_id]);
   $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
} else {
   header('location:login.php');
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
<!-- header section ends -->
<section style="margin-top: 200px;max-width:500px; margin-left: auto;
    margin-right: auto;padding:1.5rem;background:#1a1a1a;box-shadow:0 5px 25px rgba(0,0,0,0.4);border-radius:1.5rem;text-align:center;">

   <div class="user">
      <h2 style="color:#ffcc70;margin-bottom:1.2rem;font-size:1.8rem;">Profile</h2>


      
      <p style="font-size:2rem;color:#eeeeee;margin:0.4rem 0;">
         <i class="fas fa-user" style="margin-right:0.4rem;color:#ffcc70;"></i>
         <span><?= $fetch_profile['name']; ?></span>
      </p>
      
      <p style="font-size:2rem;color:#eeeeee;margin:0.4rem 0;">
         <i class="fas fa-phone" style="margin-right:0.4rem;color:#ffcc70;"></i>
         <span><?= $fetch_profile['number']; ?></span>
      </p>
      
      <p style="font-size:2rem;color:#eeeeee;margin:0.4rem 0;">
         <i class="fas fa-envelope" style="margin-right:0.4rem;color:#ffcc70;"></i>
         <span><?= $fetch_profile['email']; ?></span>
      </p>
      
      <a href="update_profile.php" 
         style="display:inline-block;margin:0.8rem 0.4rem;padding:0.6rem 1.2rem;background:#ffcc70;color:#000;font-weight:500;font-size:2rem;border-radius:2rem;text-decoration:none;">
         update info
      </a>
      
      <p style="font-size:2rem;color:#eeeeee;margin:0.4rem 0;">
         <i class="fas fa-map-marker-alt" style="margin-right:0.4rem;color:#ffcc70;"></i>
         <span><?php if($fetch_profile['address'] == ''){echo 'please enter your address';}else{echo $fetch_profile['address'];} ?></span>
      </p>
      
      <a href="update_address.php" 
         style="display:inline-block;margin:0.8rem 0.4rem;padding:0.6rem 1.2rem;background:#ffcc70;color:#000;font-weight:500;font-size:2rem;border-radius:2rem;text-decoration:none;">
         update address
      </a>
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















<!-- custom js file link  -->
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>


</body>
</html>