<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="admin-header" style="background-color: #1b1b1b; padding: 20px 30px; color: white; position: sticky; top: 0; z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.2);">
  <section class="flex" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap;">

    <a href="dashboard.php" class="logo" style="font-family: 'Forum', cursive; font-size: 2rem; color: #f9c349; text-decoration: none;">
      Admin<span style="color: white;">Panel</span>
    </a>

    <nav class="navbar" style="display: flex; gap: 20px; flex-wrap: wrap;">
      <a href="dashboard.php" class="nav-link"><span style="color: white;">Home</span></a>
      <a href="products.php" class="nav-link"><span style="color: white;">Products</span></a>
      <a href="placed_orders.php" class="nav-link"><span style="color: white;">Orders</span></a>
      <a href="admin_accounts.php" class="nav-link"><span style="color: white;">Admins</span></a>
      <a href="users_accounts.php" class="nav-link"><span style="color: white;">Users</span></a>
      <a href="messages.php" class="nav-link"><span style="color: white;">Messages</span></a>
    </nav>

    <div class="profile-dropdown" style="position: relative;">
      <div id="user-btn" class="fas fa-user" style="font-size: 1.5rem; cursor: pointer; color: #f9c349;"></div>

      <div class="profile" id="profile-box" style="display: none; position: absolute; right: 0; top: 120%; background: #2c2b2b; padding: 20px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.3); width: 220px;">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
        $select_profile->execute([$admin_id]);
        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
        <p style="color: #fff; font-weight: bold; text-align: center; margin-bottom: 15px;"><?= $fetch_profile['name']; ?></p>

        <a href="update_profile.php" class="btn" style="display: block; margin-bottom: 10px; background: #f9c349; color: #000; padding: 8px; text-align: center; border-radius: 6px;">Update Profile</a>

        <div class="flex-btn" style="display: flex; gap: 10px;">
          <a href="admin_login.php" class="option-btn" style="flex: 1; background: #444; color: #fff; padding: 6px; text-align: center; border-radius: 6px;">Login</a>
          <a href="register_admin.php" class="option-btn" style="flex: 1; background: #444; color: #fff; padding: 6px; text-align: center; border-radius: 6px;">Register</a>
        </div>

        <a href="../components/admin_logout.php" onclick="return confirm('Logout from this website?');" class="delete-btn" style="display: block; margin-top: 10px; background: #e74c3c; color: #fff; padding: 8px; text-align: center; border-radius: 6px;">Logout</a>
      </div>
    </div>

  </section>

  <script>
    const userBtn = document.getElementById('user-btn');
    const profileBox = document.getElementById('profile-box');

    userBtn.addEventListener('click', () => {
      profileBox.style.display = (profileBox.style.display === 'block') ? 'none' : 'block';
    });

    // Optional: close if clicked outside
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.profile-dropdown')) {
        profileBox.style.display = 'none';
      }
    });
  </script>
</header>
