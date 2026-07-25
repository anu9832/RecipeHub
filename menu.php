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
    <p class="text">Recipe HUb</p>
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

<section class="section menu" aria-label="menu-label" id="menu">
  <div class="container">
    <h2 class="headline-1 section-title text-center" style="margin-top: 130px;">Delicious Menu</h2>

    <!-- Category Filter Buttons -->
    <div class="category-grid" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 30px;">
      <?php 
  $categories = ['Breakfast', 'Appetizers', 'Main Course', 'Desserts', 'Drinks'];
  foreach($categories as $cat){
    $isActive = (isset($_GET['category']) && $_GET['category'] === $cat);
    $class = $isActive ? 'btn category-button active' : 'btn category-button';
    echo '<a href="menu.php?category='.urlencode($cat).'" class="'.$class.'">'.$cat.'</a>';
  }
?>
    </div>
    <!-- Heading based on selection -->
    <?php if(isset($_GET['category'])): ?>
      <h3 class="headline-1 section-title text-center"><?= htmlspecialchars($_GET['category']); ?> Menu</h3>
    <?php else: ?>
      <h3 class="headline-1 section-title text-center">Select a category to view menu</h3>
    <?php endif; ?>

    <ul class="grid-list">
      <?php
        if(isset($_GET['category'])){
          $category = $_GET['category'];
          $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
          $select_products->execute([$category]);
        } else {
          $select_products = false;
        }

        if($select_products && $select_products->rowCount() > 0){
          while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>
      <li>
        <form action="" method="post" class="menu-card hover:card">
          <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
          <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
          <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
          <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">

       <figure class="card-banner img-holder" style="--width: 100; --height: 100;">
       <img src="imgfood/<?= $fetch_products['image']; ?>" loading="lazy" alt="<?= $fetch_products['name']; ?>" class="img-cover">
        </figure>


          <div>
            <div class="title-wrapper">
              <h3 class="title-3">
                <a href="#" class="card-title"><?= $fetch_products['name']; ?></a>
              </h3>
              <span class="span title-2"><?= $fetch_products['price']; ?></span>
            </div>

            <p class="card-text label-1"><?= $fetch_products['category']; ?></p>

            <div class="flex" style="margin-top:10px; align-items:center; gap:10px;">
            <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2" 
            style="width:60px; padding:5px 10px; border:1px solid #ccc; border-radius:5px; background-color:#222; color:#fff; font-weight:bold;">

            <div style="display: flex; align-items: center; margin-top: 5px; gap: 10px;">
                <button type="submit" class="btn btn-primary label-1" name="add_to_cart" 
                    style="padding:6px 12px; background-color:#28a745; color:#fff; border:none; border-radius:5px; cursor:pointer; font-weight:bold; box-shadow:0 2px 5px rgba(0,0,0,0.3);">
                    Add to Cart
            </button>

           <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="btn btn-secondary label-1" 
              style="padding:6px 12px; background-color:#17a2b8; color:#fff; border-radius:5px; text-decoration:none; display:inline-block;   font-weight:bold; box-shadow:0 2px 5px rgba(0,0,0,0.3);">
         <i class="fas fa-eye"></i>
           </a>
          </div>


            </div>
          </div>
        </form>
      </li>
      
      <?php
          }
        } elseif(isset($_GET['category'])) {
          echo '<p class="empty">No menu items available in this category!</p>';
        } else {
          echo '<p class="empty">Please select a category to view the menu.</p>';
        }
      ?>
    </ul>
<div class="category-grid" style="display: flex; flex-wrap: wrap; gap: 15px; justify-content: center; margin-bottom: 30px;">
      <?php 
  $categories = ['Breakfast', 'Appetizers', 'Main Course', 'Desserts', 'Drinks'];
  foreach($categories as $cat){
    $isActive = (isset($_GET['category']) && $_GET['category'] === $cat);
    $class = $isActive ? 'btn category-button active' : 'btn category-button';
    echo '<a href="menu.php?category='.urlencode($cat).'" class="'.$class.'">'.$cat.'</a>';
  }
?>
    </div>
    <img src="./assets/images/shape-5.png" width="921" height="1036" loading="lazy" alt="shape" class="shape shape-2 move-anim">
    <img src="./assets/images/shape-6.png" width="343" height="345" loading="lazy" alt="shape" class="shape shape-3 move-anim">
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
  /* Base category button style */
.category-button {
  padding: 10px 20px;
  border: none;
  background-color:pink;
  color: black;
  transition: all 0.3s ease;
  text-decoration: none;
}

/* Hover effect for normal buttons */
.category-button:hover {
  background-color:rgb(232, 95, 150);
  color: white;
}

/* Active category styling */
.category-button.active {
  background-color:rgb(104, 55, 112);
  color: white;
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

<!-- custom js file link  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>

</body>
</html>