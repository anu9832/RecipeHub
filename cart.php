<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:index.php');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'cart item deleted!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:cart.php');
   $message[] = 'deleted all from cart!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
}

$grand_total = 0;

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


<section class="section" style="padding-block: 200px 100px; background-color: var(--eerie-black);">
  <div class="container">
    <p class="section-subtitle text-center label-2">Your Basket</p>
    <h2 class="headline-1 section-title text-center">Shopping Cart</h2>

    <div class="grid-list" style="margin-block: 40px;">

      <?php
        $grand_total = 0;
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if($select_cart->rowCount() > 0){
          while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="menu-card hover:card" style="padding: 20px; background-color: var(--smoky-black-2); border-radius: 12px;">

        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">

     <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
  <img src="imgfood/<?= $fetch_cart['image']; ?>" loading="lazy" alt="<?= $fetch_cart['name']; ?>" class="img-cover">
</figure>



        <div>
          <div class="title-wrapper">
            <h3 class="title-3"><?= $fetch_cart['name']; ?></h3>
            <span class="span title-2"><?= $fetch_cart['price']; ?></span>
          </div>

         <div style="margin-top: 10px; display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
  
  <input type="number" name="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>"
    style="width: 80px; padding: 6px 12px; border-radius: 8px; border: 1px solid var(--gold-crayola); background-color: var(--eerie-black); color: white; font-family: 'DM Sans', sans-serif; font-size: 16px;">

  <button type="submit" name="update_qty"
    style="background-color: var(--gold-crayola); color: var(--black); padding: 10px 20px; font-family: 'DM Sans', sans-serif; font-size: 16px; border-radius: 50px; border: none; cursor: pointer;">
    Update
  </button>

  <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>"
    style="background-color: transparent; color: var(--gold-crayola); padding: 10px 20px; font-family: 'DM Sans', sans-serif; font-size: 16px; border: 1px solid var(--gold-crayola); border-radius: 50px; text-decoration: none; display: inline-block;">
    View
  </a>

  <button type="submit" name="delete" onclick="return confirm('Delete this item?');"
    style="background-color: #d9534f; color: white; padding: 10px 20px; font-family: 'DM Sans', sans-serif; font-size: 16px; border-radius: 50px; border: none; cursor: pointer;">
    Delete
  </button>
</div>

          <p class="card-text label-1" style="margin-top: 10px;">Subtotal: <span class="span"><?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?></span></p>
        </div>

      </form>
      <?php
            $grand_total += $sub_total;
          }
        } else {
          echo '<p class="text-center label-2" style="color: var(--white); font-size: 20px;">Your cart is empty</p>';
        }
      ?>
    </div>

 <div style="text-align: center; margin-top: 30px;">
  <p class="section-subtitle" style="color: var(--gold-crayola); font-size: 20px; font-family: 'DM Sans', sans-serif;">
    Cart Total: <span><?= $grand_total; ?></span>
  </p>

  <a href="checkout.php"
     style="background-color: var(--gold-crayola); color: var(--black); padding: 10px 25px; font-family: 'DM Sans', sans-serif; font-size: 16px; border-radius: 50px; text-decoration: none; display: inline-block; <?= ($grand_total > 1) ? '' : 'pointer-events: none; opacity: 0.5;' ?>">
     Proceed to Checkout
  </a>
</div>

<div style="text-align: center; margin-top: 20px;">
  <form action="" method="post" style="display: inline-block; margin-right: 10px;">
    <button type="submit" name="delete_all" onclick="return confirm('Delete all from cart?');"
      style="background-color: #d9534f; color: white; padding: 10px 25px; font-family: 'DM Sans', sans-serif; font-size: 16px; border-radius: 50px; border: none; cursor: pointer; <?= ($grand_total > 1) ? '' : 'pointer-events: none; opacity: 0.5;' ?>">
      Delete All
    </button>
  </form>

  <a href="menu.php"
     style="background-color: transparent; color: var(--gold-crayola); padding: 10px 25px; font-family: 'DM Sans', sans-serif; font-size: 16px; border: 1px solid var(--gold-crayola); border-radius: 50px; text-decoration: none; display: inline-block;">
     Continue Shopping
  </a>
</div>
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
  background-color: var(--eerie-black);
  border: 1px solid var(--gold-crayola);
  color: white;
  padding: 6px 12px;
  border-radius: 8px;
}
.img-holder {
  width: 100px;
  height: 100px;
  overflow: hidden;
  display: inline-block; /* or block, depending on layout */
  border-radius: 6px; /* optional */
  background: #f0f0f0; /* optional placeholder bg */
}

.img-cover {
  width: 100%;
  height: 100%;
  object-fit: cover;  /* ensures image covers box without distortion */
  display: block;
}
  </style>
<!-- JS -->
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>

</body>
</html>
