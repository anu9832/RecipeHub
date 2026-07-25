<?php
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Handle mark as read POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_read_id'], $_POST['mark_read_type'])) {
    $id = $_POST['mark_read_id'];
    $type = $_POST['mark_read_type'];

    if ($type === 'order') {
        $stmt = $conn->prepare("UPDATE orders SET user_read = 1 WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    } elseif ($type === 'reservation') {
        $stmt = $conn->prepare("UPDATE reservation SET user_read = 1 WHERE reserve_id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    }
    // Redirect to avoid resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
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
        <span class="span">contact@recipwhubdelhi.com</span>
      </a>
    </div>
  </div>
  <?php include 'components/user_header.php'; ?>

  <section class="notification-section">
    <h2><i class="fas fa-bell"></i> Your Notifications</h2>

    <?php
    // Fetch unread orders
    $stmt_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ? AND payment_status = 'completed' AND user_read = 0 ORDER BY placed_on DESC");
    $stmt_orders->execute([$user_id]);

    $order_found = false;
    while ($order = $stmt_orders->fetch(PDO::FETCH_ASSOC)) {
      $order_found = true;
      $admin_message = $order['admin_reply'] ?: "You'll get your food at your doorstep in 30 mins.";
      echo '<div class="notification-card">';
      echo '<h3>Order Update</h3>';
      echo '<p><strong>Date:</strong> ' . $order['placed_on'] . '</p>';
      echo '<p><strong>Message:</strong> ' . htmlspecialchars($admin_message) . '</p>';
      echo '<form method="post" style="position:absolute; top:20px; right:20px;">';
      echo '<input type="hidden" name="mark_read_id" value="' . $order['id'] . '">';
      echo '<input type="hidden" name="mark_read_type" value="order">';
      echo '<button type="submit" class="mark-read-btn">Mark as Read</button>';
      echo '</form>';
      echo '</div>';
    }

    // Fetch unread reservations
    $stmt_res = $conn->prepare("SELECT * FROM reservation WHERE user_id = ? AND status = 'approved' AND user_read = 0 ORDER BY date_res DESC, time DESC");
    $stmt_res->execute([$user_id]);

    $reservation_found = false;
    while ($res = $stmt_res->fetch(PDO::FETCH_ASSOC)) {
      $reservation_found = true;
      $admin_reply = $res['admin_reply'] ?: "Thanks for booking!";
      echo '<div class="notification-card">';
      echo '<h3>Reservation Update</h3>';
      echo '<p><strong>Date:</strong> ' . $res['date_res'] . ' @ ' . $res['time'] . '</p>';
      echo '<p><strong>Message:</strong> ' . htmlspecialchars($admin_reply) . '</p>';
      echo '<form method="post" style="position:absolute; top:20px; right:20px;">';
      echo '<input type="hidden" name="mark_read_id" value="' . $res['reserve_id'] . '">';
      echo '<input type="hidden" name="mark_read_type" value="reservation">';
      echo '<button type="submit" class="mark-read-btn">Mark as Read</button>';
      echo '</form>';
      echo '</div>';
    }

    if (!$order_found && !$reservation_found) {
      echo '<p style="text-align:center; color:#999;">No new notifications yet.</p>';
    }
    ?>
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
  body {
      font-family: 'DM Sans', sans-serif;
      background-color: #0e0e0e;
      color: white;
    }
    .notification-section {
      padding: 210px 20px;
      max-width: 1000px;
      margin: auto;
    }
    .notification-section h2 {
      text-align: center;
      font-size: 2.5rem;
      margin-bottom: 30px;
      color: #f9c349;
    }
    .notification-card {
      background-color: #1e1e1e;
      border: 1px solid #444;
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 20px;
      position: relative;
    }
    .notification-card h3 {
      font-size: 2rem;
      color: #f9c349;
      margin-bottom: 10px;
    }
    .notification-card p {
      color: #ccc;
      font-size: 1.3rem;
      margin: 5px 0;
    }
.mark-read-btn {
  background: #f9c349;
  border: none;
  padding: 8px 15px;
  border-radius: 8px;
  font-weight: bold;
  color: #111;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-top: 35px;       /* space above the button */
  display: inline-block;  /* so it behaves like a button inline */
}

.mark-read-btn:hover {
  background: #d4a90a;
}
  </style>
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>
</body>

</html>
