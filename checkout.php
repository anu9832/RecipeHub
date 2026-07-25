<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'please add your address!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
      
   }else{
      $message[] = 'your cart is empty';
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
<!-- HEADER -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<section class="section" style="padding-block: 200px; background-color: var(--eerie-black);">
  <div class="container">

    <p class="section-subtitle text-center label-2">Your Cart</p>
    <h2 class="headline-1 section-title text-center">Checkout</h2>

<form action="" method="post" style="margin-top: 50px; font-family: 'DM Sans', sans-serif;">

  <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">

    <!-- Cart Items Summary -->
    <div style="background-color: var(--smoky-black-2); padding: 30px; border-radius: 12px;">
      <h3 style="color: var(--gold-crayola); margin-bottom: 20px; font-size: 24px;">Order Summary</h3>

      <?php
      $grand_total = 0;
      $cart_items[] = '';
      $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
      $select_cart->execute([$user_id]);
      if($select_cart->rowCount() > 0){
        while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
          $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
          $total_products = implode($cart_items);
          $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
        <p style="color: white; margin-bottom: 10px; font-size: 16px; display: flex; justify-content: space-between;">
          <span><?= htmlspecialchars($fetch_cart['name']); ?></span>
          <span><?= number_format($fetch_cart['price'], 2); ?> × <?= (int)$fetch_cart['quantity']; ?></span>
        </p>
      <?php
        }
      } else {
        echo '<p style="color: #999; font-size: 16px;">Your cart is empty!</p>';
      }
      ?>
      <p style="margin-top: 20px; font-size: 18px; font-weight: 600; color: var(--gold-crayola); display: flex; justify-content: space-between;">
        <span>Grand Total:</span>
        <span><?= number_format($grand_total, 2); ?></span>
      </p>

     <a href="cart.php" 
   style="margin-top: 20px; display: inline-block; background-color: var(--gold-crayola); color: var(--black); padding: 12px 30px; border-radius: 50px; text-decoration: none; font-weight: 600; font-size: 16px;">
   View Cart
</a>
    </div>

    <!-- User Info & Payment -->
    <div style="background-color: var(--smoky-black-2); padding: 30px; border-radius: 12px;">
      <h3 style="color: var(--gold-crayola); margin-bottom: 20px; font-size: 24px;">Your Info</h3>

      <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products ?? ''); ?>">
      <input type="hidden" name="total_price" value="<?= htmlspecialchars($grand_total); ?>">
      <input type="hidden" name="name" value="<?= htmlspecialchars($fetch_profile['name']); ?>">
      <input type="hidden" name="number" value="<?= htmlspecialchars($fetch_profile['number']); ?>">
      <input type="hidden" name="email" value="<?= htmlspecialchars($fetch_profile['email']); ?>">
      <input type="hidden" name="address" value="<?= htmlspecialchars($fetch_profile['address']); ?>">

      <p style="color: white; font-size: 16px; margin-bottom: 8px;"><i class="fas fa-user"></i> <?= htmlspecialchars($fetch_profile['name']); ?></p>
      <p style="color: white; font-size: 16px; margin-bottom: 8px;"><i class="fas fa-phone"></i> <?= htmlspecialchars($fetch_profile['number']); ?></p>
      <p style="color: white; font-size: 16px; margin-bottom: 12px;"><i class="fas fa-envelope"></i> <?= htmlspecialchars($fetch_profile['email']); ?></p>
      <a href="update_profile.php" 
   style="display: inline-block; margin-bottom: 30px; background-color: var(--gold-crayola); color: var(--black); padding: 10px 25px; border-radius: 50px; font-weight: 600; text-decoration: none; font-size: 16px;">
   Update Info
</a>
      <h3 style="color: var(--gold-crayola); margin-bottom: 10px; font-size: 20px;">Delivery Address</h3>
      <p style="color: white; font-size: 16px; margin-bottom: 12px;">
        <i class="fas fa-map-marker-alt"></i> 
        <?= ($fetch_profile['address'] == '') ? 'Please enter your address' : htmlspecialchars($fetch_profile['address']); ?>
      </p>
      <a href="update_address.php" 
   style="display: inline-block; margin-bottom: 30px; background-color: var(--gold-crayola); color: var(--black); padding: 10px 25px; border-radius: 50px; font-weight: 600; text-decoration: none; font-size: 16px;">
   Update Address
</a>


      <select name="method" required
              style="width: 100%; padding: 12px 15px; border-radius: 12px; background-color: #065f46; color: white; border: 1.5px solid #14b8a6; font-size: 16px;">
        <option value="" disabled selected style="color: #a7f3d0;">Select Payment Method</option>
        <option value="cash on delivery">Cash on Delivery</option>
        <option value="credit card">Credit Card</option>
        <option value="paytm">Paytm</option>
        <option value="paypal">Paypal</option>
      </select>
    <input type="submit" value="Place Order" name="submit" 
       style="width: 200px; margin-top: 25px; background-color: var(--gold-crayola); color: var(--black); padding: 14px 0; border-radius: 50px; font-weight: 700; font-size: 18px; border: none; cursor: pointer; <?= ($fetch_profile['address'] == '') ? 'pointer-events: none; opacity: 0.5;' : ''; ?>">

    </div>

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
  <style>
  .input-field {
  border-radius: 8px;
  border: 1px solid var(--gold-crayola);
  background-color: var(--eerie-black);
  color: var(--white);
  padding: 12px;
  font-size: 16px;
}
  </style>
<!-- custom js file link  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>
</body>
</html>
