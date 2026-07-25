<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
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
  <title>Recipe Hub - Cravings Met, Taste Elevated</title>
  <meta name="title" content="Recipe Hub - Cravings Met, Taste Elevated">
  <meta name="description" content="This is a Restaurant html template made by anushuya">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./fav1.svg" type="image/svg+xml">
  <!-- Font Awesome & Google Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet" />

  <!-- Custom CSS -->

  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--eerie-black, #0e0e0e);
      color: white;
    }

    .dashboard {
      padding: 40px 20px;
      max-width: 1200px;
      margin: auto;
    }

    .heading {
      font-family: 'Forum', cursive;
      font-size: 3rem;
      color: var(--gold-crayola, #f9c349);
      margin-bottom: 40px;
      text-align: center;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .box {
      background-color: var(--smoky-black-2, #1c1b1b);
      border: 1px solid var(--gold-crayola, #f9c349);
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      transition: transform 0.3s;
    }

    .box:hover {
      transform: translateY(-5px);
    }

    .box h3 {
      font-size: 2rem;
      color: var(--white, #fff);
    }

    .box p {
      color: var(--light-gray, #ccc);
      font-size: 1rem;
      margin-bottom: 15px;
    }

    .btn {
      display: inline-block;
      background-color: var(--gold-crayola, #f9c349);
      color: var(--black, #000);
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .btn:hover {
      background-color: var(--white, #fff);
    }
  </style>
</head>
<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="dashboard">

    <h1 class="heading">Admin Dashboard</h1>

    <div class="box-container">

      <div class="box">
        <h3>Welcome!</h3>
        <p><?= $_SESSION['admin_name'] ?? 'Admin' ?></p>
        <a href="update_profile.php" class="btn">Update Profile</a>
      </div>

      <div class="box">
        <?php
          $total_pendings = 0;
          $select = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
          $select->execute(['pending']);
          while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $total_pendings += $row['total_price'];
          }
        ?>
        <h3><?= $total_pendings ?>/-</h3>
        <p>Total Pendings</p>
        <a href="placed_orders.php" class="btn">View Orders</a>
      </div>

      <div class="box">
        <?php
          $total_completes = 0;
          $select = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
          $select->execute(['completed']);
          while($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $total_completes += $row['total_price'];
          }
        ?>
        <h3><?= $total_completes ?>/-</h3>
        <p>Total Completed</p>
        <a href="placed_orders.php" class="btn">View Orders</a>
      </div>

      <div class="box">
        <?php
          $select = $conn->prepare("SELECT * FROM `orders`");
          $select->execute();
          $count = $select->rowCount();
        ?>
        <h3><?= $count ?></h3>
        <p>Total Orders</p>
        <a href="placed_orders.php" class="btn">View Orders</a>
      </div>

      <div class="box">
        <?php
          $select = $conn->prepare("SELECT * FROM `products`");
          $select->execute();
          $count = $select->rowCount();
        ?>
        <h3><?= $count ?></h3>
        <p>Products Added</p>
        <a href="products.php" class="btn">View Products</a>
      </div>

      <div class="box">
        <?php
          $select = $conn->prepare("SELECT * FROM `users`");
          $select->execute();
          $count = $select->rowCount();
        ?>
        <h3><?= $count ?></h3>
        <p>Users</p>
        <a href="users_accounts.php" class="btn">View Users</a>
      </div>

      <div class="box">
        <?php
          $select = $conn->prepare("SELECT * FROM `admin`");
          $select->execute();
          $count = $select->rowCount();
        ?>
        <h3><?= $count ?></h3>
        <p>Admins</p>
        <a href="admin_accounts.php" class="btn">View Admins</a>
      </div>
       <div class="box">
  <?php
    $select = $conn->prepare("SELECT * FROM `reservation`");
    $select->execute();
    $count = $select->rowCount();
  ?>
  <h3><?= $count ?></h3>
  <p>Reservations</p>
  <a href="reservations.php" class="btn">View Reservations</a>
</div>

      <div class="box">
        <?php
          $select = $conn->prepare("SELECT * FROM `messages`");
          $select->execute();
          $count = $select->rowCount();
        ?>
        <h3><?= $count ?></h3>
        <p>Messages</p>
        <a href="messages.php" class="btn">View Messages</a>
      </div>


    </div>
  </section>

  <script src="../js/admin_script.js"></script>
</body>
</html>
