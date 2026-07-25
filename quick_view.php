<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

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
   
<?php include 'components/user_header.php'; ?>

<div class="quick-view">
   <h1 class="title">Quick View</h1>

   <?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="quick-box">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

      <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
      
      <div class="name"><?= $fetch_products['name']; ?></div>
      
      <p class="desc"><?= $fetch_products['description']; ?></p>

      <div class="flex">
         <div class="price"><span></span><?= $fetch_products['price']; ?></div>
         <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
      </div>
      <button type="submit" name="add_to_cart" class="cart-btn">Add to Cart</button>
   </form>
   <?php
         }
      } else {
         echo '<p class="empty">No products added yet!</p>';
      }
   ?>
</div>
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

          <a href="mailto:contact@recipehuddelhi.com" class="body-4 contact-link">contact@recipehubdelhi.com</a>

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
.quick-view {
  max-width: 900px;
  margin: 19rem auto 10rem auto; /* pushes it a bit lower */
  padding: 2rem;
  text-align: center;
}

.quick-view .title {
  font-size: 2.2rem;
  font-weight: 600;
  color: #1a1a1a;
  margin-bottom: 3rem;
  text-transform: capitalize;
  position: relative;
}

.quick-box {
  background: #fff9f0;
  padding: 2.5rem;
  border-radius: 1.25rem;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  text-align: center;
  transition: 0.3s ease;
}

.quick-box img {
  width: 100%;
  max-width: 300px;
  border-radius: 1rem;
  margin-bottom: 1rem;
}

.quick-box .cat {
  display: inline-block;
  margin-bottom: 0.5rem;
  font-size: 0.95rem;
  color: #e67e22;
  text-decoration: none;
  font-weight: 500;
}

.quick-box .name {
  font-size: 1.8rem;
  color: #222;
  font-weight: 600;
  margin-bottom: 1rem;
}

.quick-box .desc {
  font-size: 1rem;
  color: #555;
  margin-bottom: 1.5rem;
  line-height: 1.6;
  font-style: italic;
}

.quick-box .flex {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 1.5rem;
  margin: 1.5rem 0;
}

.quick-box .price {
  font-size: 1.3rem;
  color: #e67e22;
  font-weight: 600;
}

.quick-box .qty {
  width: 70px;
  padding: 0.4rem;
  border: 1px solid #ccc;
  border-radius: 0.5rem;
  font-size: 1rem;
  text-align: center;
}

.quick-box .cart-btn {
  padding: 0.75rem 1.5rem;
  font-size: 1rem;
  background-color: #e67e22;
  color: #fff;
  border: none;
  border-radius: 0.75rem;
  cursor: pointer;
  transition: 0.3s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.quick-box .cart-btn:hover {
  background-color: #cf711f;
}

</style>
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>

</body>
</html>