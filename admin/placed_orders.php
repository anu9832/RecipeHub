<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" />

  <style>
    body {
      margin: 0;
      background-color: #1b1b1b;
      font-family: 'DM Sans', sans-serif;
      color: white;
    }

    h1.heading {
      text-align: center;
      padding: 40px 20px 10px;
      font-size: 36px;
      color: #f5c518;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
      gap: 20px;
      padding: 20px;
      max-width: 1200px;
      margin: auto;
    }

    .box {
      background-color: #2c2c2c;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }

    .box p {
      margin-bottom: 10px;
      font-size: 15px;
      color: #ccc;
    }

    .box span {
      color: #fff;
      font-weight: 500;
    }

    .drop-down {
      width: 100%;
      padding: 10px;
      background-color: #3a3a3a;
      color: #fff;
      border: none;
      border-radius: 8px;
      margin: 10px 0;
    }

    .flex-btn {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }

    .btn, .delete-btn {
      flex: 1;
      padding: 10px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 14px;
      border: none;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
    }

    .btn {
      background-color: #f5c518;
      color: black;
    }

    .btn:hover {
      background-color: #fff;
    }

    .delete-btn {
      background-color: #e74c3c;
      color: white;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    .empty {
      text-align: center;
      color: #999;
      padding: 40px;
      font-size: 18px;
    }
  </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="placed-orders">
  <h1 class="heading">Placed Orders</h1>

  <div class="box-container">
    <?php
      $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC");
      $select_orders->execute();
      if($select_orders->rowCount() > 0){
         while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
      <p>User ID: <span><?= $fetch_orders['user_id']; ?></span></p>
      <p>Placed On: <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name: <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email: <span><?= $fetch_orders['email']; ?></span></p>
      <p>Number: <span><?= $fetch_orders['number']; ?></span></p>
      <p>Address: <span><?= $fetch_orders['address']; ?></span></p>
      <p>Items: <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Total Price: <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
      <p>Payment Method: <span><?= $fetch_orders['method']; ?></span></p>
      <form action="" method="post">
        <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
        <select name="payment_status" class="drop-down" required>
          <option value="" disabled selected><?= $fetch_orders['payment_status']; ?></option>
          <option value="pending">Pending</option>
          <option value="completed">Completed</option>
        </select>
        <div class="flex-btn">
          <input type="submit" value="Update" class="btn" name="update_payment">
          <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('Delete this order?');">Delete</a>
        </div>
      </form>
    </div>
    <?php
         }
      } else {
        echo '<p class="empty">No orders placed yet!</p>';
      }
    ?>
  </div>
</section>

</body>
</html>