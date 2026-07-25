<?php

$user_id = $_SESSION['user_id'] ?? null;
$total_cart_items = 0;
$total_notifications = 0;

if ($user_id) {
    // Count unread completed orders
    $order_query = $conn->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ? AND payment_status = 'completed' AND user_read = 0");
    $order_query->execute([$user_id]);
    $total_notifications += $order_query->fetchColumn();

    // Count approved reservations not yet read
    $res_query = $conn->prepare("SELECT COUNT(*) FROM reservation WHERE user_id = ? AND status = 'approved' AND user_read = 0");
    $res_query->execute([$user_id]);
    $total_notifications += $res_query->fetchColumn();
}
// Fetch cart item count if user is logged in
if ($user_id) {
    $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $count_cart_items->execute([$user_id]);
    $total_cart_items = $count_cart_items->rowCount();
}
?>
<body>
<header class="header" data-header>
  <div class="container">

  <a href="index.php" class="logo">
        <img src="./assets/images/logo 1.png" width="200" height="200" alt="Crave Haven - Home">
      </a>


    <nav class="navbar" data-navbar>
      <ul class="navbar-list">

        <li class="nav-item">
          <a href="index.php" class="navbar-link" data-nav-link>Home</a>
        </li>

        <li class="nav-item">
          <a href="index.php#about" class="navbar-link" data-nav-link>About</a>
        </li>

        <li class="nav-item">
          <a href="menu.php" class="navbar-link" data-nav-link>Menu</a>
        </li>

        <li class="nav-item">
          <a href="orders.php" class="navbar-link" data-nav-link>Orders</a>
        </li>

        <li class="nav-item">
          <a href="index.php#reservation" class="navbar-link" data-nav-link>Contact</a>
        </li>
     <li class="nav-item" style="position: relative;">
  <a href="notifications.php" class="navbar-link" data-nav-link>
    Notifications
    <?php if ($total_notifications > 0): ?>
    <span class="notif-dot"></span>
    <?php endif; ?>
  </a>
</li>

      </ul>


    </nav>
    <a href="search.php"><i class="fas fa-search"></i></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
      
      <!-- User Icon -->
      <div class="user-menu-wrapper">
        <button class="btn btn-hover" id="user-icon">
          <i class="fas fa-user"></i>
        </button>

      <div id="profile-box" class="profile-box" style="background:#fff; border:2px solid #ccc; border-radius:12px; padding:20px; width:280px; box-shadow:0 4px 12px rgba(0,0,0,0.1); text-align:center; margin:20px auto; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <?php
        $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if($select_profile->rowCount() > 0){
           $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
    ?>
    <p class="name" style="font-size:20px; font-weight:600; margin-bottom:15px; color:#333;">
        <?= $fetch_profile['name']; ?>
    </p>
    <div class="flex" style="display:flex; justify-content:center; gap:10px; margin-bottom:15px;">
        <a href="profile.php" style="padding:8px 16px; background:#28a745; color:white; text-decoration:none; border-radius:6px; font-size:14px; text-transform:none;">Profile</a>

        <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn" style="padding:8px 16px; background:#dc3545; color:white; text-decoration:none; border-radius:6px; font-size:14px;">Logout</a>
    </div>
    <div style="display:flex; justify-content:center; gap:10px;">
        <a href="login.php" style="color:#007bff; text-decoration:none; font-size:14px;">Login</a>
        <span style="color:#666;">or</span>
        <a href="register.php" style="color:#007bff; text-decoration:none; font-size:14px;">Register</a>
    </div>
 <?php
    } else {
?>
<p class="name" style="font-size:18px; font-weight:500; color:#dc3545; margin-bottom:15px;">Please login first!</p>
<div style="text-align:center;">
    <a href="login.php" style="display:inline-block; padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:6px; font-size:14px; text-transform:none;">Login</a>
</div>
<?php
    }
?>

</div>

      </div>
    </div>

      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <span class="line line-1"></span>
        <span class="line line-2"></span>
        <span class="line line-3"></span>
      </button>

      <div class="overlay" data-nav-toggler data-overlay></div>

    </div>
  </header>
<?php if (!empty($message)): ?>
  <div class="user-message-wrapper" id="userMessage">
    <?php foreach ((array)$message as $msg): ?>
      <div class="user-alert">
        <span><?= $msg; ?></span>
        <i class="fas fa-times close-btn" id="closeMessage"></i>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>
  <style>
 .user-menu-wrapper {
  position: relative;
  z-index: 1000;
}

.profile-box {
  display: none;
  position: absolute;
  top: 120%;
  right: 0;
  background-color: #fff;
  border-radius: 16px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
  width: 240px;
  padding: 1.5rem;
  transition: all 0.3s ease;
  font-family: 'DM Sans', sans-serif;
}

.profile-box.show {
  display: block;
}

#user-icon {
  background: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: #fff;
 border-radius: 16px;
}

#user-icon:hover {
  color: #ad343e;
}
.user-message-wrapper {
  position: fixed;
  top: 80px; /* Adjust based on header height */
  right: 20px;
  z-index: 9999;
  width: 280px;
}

.user-alert {
  background-color: #fff7f6;
  color: #ad343e;
  border-left: 4px solid #ad343e;
  padding: 12px 16px;
  margin-bottom: 10px;
  border-radius: 10px;
  box-shadow: 0 8px 16px rgba(0,0,0,0.1);
  font-size: 14px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  font-family: 'DM Sans', sans-serif;
}

.user-alert .close-btn {
  cursor: pointer;
  font-size: 18px;
  margin-left: 10px;
  color: #ad343e;
}

.notif-dot {
  position: absolute;
  top: 2px;
  right: 2px;
  width: 10px;
  height: 10px;
  background-color: red;
  border-radius: 50%;
}

</style>
</header>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const userIcon = document.getElementById('user-icon');
    const profileBox = document.getElementById('profile-box');

    if (userIcon && profileBox) {
      userIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        profileBox.classList.toggle('show');
      });

      document.addEventListener('click', (e) => {
        if (!profileBox.contains(e.target) && !userIcon.contains(e.target)) {
          profileBox.classList.remove('show');
        }
      });
    }
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", () => {
    const closeBtn = document.querySelector("#closeMessage");
    const msgWrapper = document.querySelector("#userMessage");

    if (closeBtn && msgWrapper) {
      closeBtn.addEventListener("click", () => {
        msgWrapper.style.display = "none";
      });
    }
  });
</script>


</body>