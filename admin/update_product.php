<?php

include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? '';
if (!$admin_id) {
  header('location:admin_login.php');
  exit;
}

if (isset($_POST['update'])) {
  $pid = $_POST['pid'];
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $price = filter_var($_POST['price'], FILTER_SANITIZE_STRING);
  $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);

  $conn->prepare("UPDATE `products` SET name = ?, category = ?, price = ? WHERE id = ?")->execute([$name, $category, $price, $pid]);

  $old_image = $_POST['old_image'];
  $image = $_FILES['image']['name'];
  $image = filter_var($image, FILTER_SANITIZE_STRING);
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_size = $_FILES['image']['size'];
  $image_folder = '../uploaded_img/' . $image;

  if (!empty($image)) {
    if ($image_size > 2000000) {
      $message[] = 'image size too large!';
    } else {
      $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?")->execute([$image, $pid]);
      move_uploaded_file($image_tmp_name, $image_folder);
      unlink('../uploaded_img/' . $old_image);
      $message[] = 'image updated!';
    }
  }

  $message[] = 'product updated!';
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
  <title>Crave Haven - Satisfy Your Cravings, Elevate Your Taste!</title>
  <meta name="title" content="Crave Haven - Satisfy Your Cravings, Elevate Your Taste!">
  <meta name="description" content="This is a Restaurant html template made by gayatri">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./fav.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" />
  <style>
    body {
      margin: 0;
      background-color: #1b1b1b;
      font-family: 'DM Sans', sans-serif;
      color: #fff;
    }

    section.update-product {
      max-width: 600px;
      margin: 80px auto;
      padding: 30px;
      background-color: #2c2c2c;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .heading {
      text-align: center;
      font-size: 2rem;
      color: #f5c518;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    form span {
      margin: 10px 0 5px;
      font-size: 14px;
      color: #ccc;
    }

    .box {
      padding: 12px 15px;
      margin-bottom: 12px;
      border-radius: 8px;
      background-color: #3c3c3c;
      border: none;
      color: white;
      font-size: 16px;
    }

    img {
      width: 100%;
      max-height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .flex-btn {
      display: flex;
      justify-content: space-between;
      gap: 10px;
      margin-top: 20px;
    }

    .btn, .option-btn {
      flex: 1;
      padding: 12px;
      font-weight: bold;
      font-size: 15px;
      text-align: center;
      text-decoration: none;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      color: #fff;
      transition: background 0.3s ease;
    }

    .btn {
      background-color: #f5c518;
      color: #1b1b1b;
    }

    .btn:hover {
      background-color: #fff;
      color: #000;
    }

    .option-btn {
      background-color: #3498db;
    }

    .option-btn:hover {
      background-color: #2980b9;
    }

    .empty {
      text-align: center;
      font-size: 1.2rem;
      color: #ccc;
      padding: 50px;
    }
  </style>
</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="update-product">
    <h1 class="heading">Update Product</h1>

    <?php
    if (isset($_GET['update'])) {
      $update_id = $_GET['update'];
      $product = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
      $product->execute([$update_id]);
      if ($product->rowCount() > 0) {
        $data = $product->fetch(PDO::FETCH_ASSOC);
    ?>
        <form action="" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="pid" value="<?= $data['id']; ?>">
          <input type="hidden" name="old_image" value="<?= $data['image']; ?>">

          <img src="../uploaded_img/<?= $data['image']; ?>" alt="Product image">

          <span>Update Name</span>
          <input type="text" name="name" class="box" required value="<?= $data['name']; ?>">

          <span>Update Price</span>
          <input type="number" name="price" class="box" min="0" max="9999999999" required value="<?= $data['price']; ?>">

          <span>Update Category</span>
          <select name="category" class="box" required>
            <option selected value="<?= $data['category']; ?>"><?= $data['category']; ?></option>
            <option value="main dish">Main Dish</option>
            <option value="fast food">Fast Food</option>
            <option value="drinks">Drinks</option>
            <option value="desserts">Desserts</option>
          </select>

          <span>Update Image</span>
          <input type="file" name="image" class="box" accept="image/*">

          <div class="flex-btn">
            <input type="submit" value="Update" name="update" class="btn">
            <a href="products.php" class="option-btn">Go Back</a>
          </div>
        </form>
    <?php
      } else {
        echo '<p class="empty">No product found!</p>';
      }
    } else {
      echo '<p class="empty">No product selected!</p>';
    }
    ?>
  </section>

</body>

</html>
