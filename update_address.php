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

$message = [];
$redirect = false;

if(isset($_POST['submit'])){

   $flat = $_POST['flat'];
   $building = $_POST['building'];
   $pin_code = $_POST['pin_code'];

   // Server-side validations
   if(strlen($flat) > 3 || strlen($building) > 3){
       $message[] = 'Flat and Building number must be up to 3 digits.';
   }

   if(strlen($pin_code) != 6){
       $message[] = 'Pin Code must be exactly 6 digits.';
   }

   if(empty($message)){
       $address = $flat .', '.$building.', '.$_POST['area'].', '.$_POST['town'] .', '. $_POST['city'] .', '. $_POST['state'] .', '. $_POST['country'] .' - '. $pin_code;
       $address = filter_var($address, FILTER_SANITIZE_STRING);

       $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
       $update_address->execute([$address, $user_id]);

       // Set redirect flag
       $redirect = true;
   }
}

if($redirect){
   // Redirect immediately after saving
   header('Location: index.php');
   exit;
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
  

      <h2 class="headline-1 text-center" style="color: var(--gold-crayola); margin-bottom: 30px;">Your Address</h2>

      <?php
      if(!empty($message)){
          foreach($message as $msg){
              echo '<p style="
                background-color: #333; 
                color: #ffcc00; 
                padding: 12px 20px; 
                border-radius: 8px; 
                font-weight: bold; 
                text-align: center;
                margin-bottom: 20px;
                box-shadow: 0 0 10px #ffcc00;
                ">' . htmlspecialchars($msg) . '</p>';
          }
      }
      ?>

      <form action="" method="post">

        <input type="number" name="flat" placeholder="Flat No." required min="0" max="999"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;"
          oninput="if(this.value.length > 3) this.value = this.value.slice(0,3);">

        <input type="number" name="building" placeholder="Building No." required min="0" max="999"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;"
          oninput="if(this.value.length > 3) this.value = this.value.slice(0,3);">

        <input type="text" name="area" placeholder="Area Name" required maxlength="50"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;">

        <input type="text" name="town" placeholder="Town Name" required maxlength="50"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;">

        <input type="text" name="city" placeholder="City Name" required maxlength="50"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;">

        <input type="text" name="state" placeholder="State Name" required maxlength="50"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;">

        <input type="text" name="country" placeholder="Country Name" required maxlength="50"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 15px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;">

        <input type="number" name="pin_code" placeholder="Pin Code" required min="100000" max="999999"
          class="input-field"
          style="width: 100%; padding: 14px; margin-bottom: 25px; border-radius: 10px; border: none; background-color: var(--smoky-black); color: white;"
          oninput="if(this.value.length > 6) this.value = this.value.slice(0,6);">

      <div style="display: flex; justify-content: center;">
  <input type="submit" name="submit" value="Save Address" class="btn btn-primary"
    style="width: 100%; max-width: 300px; padding: 14px; font-weight: bold; cursor: pointer; background-color: var(--gold-crayola); border: none; border-radius: 10px; color: black; box-shadow: none; transition: background-color 0.3s ease;">
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
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>
