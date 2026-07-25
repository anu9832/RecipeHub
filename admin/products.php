<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exists!';
   }else{
      if($image_size > 2000000){
         $message[] = 'image size is too large';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, price, image) VALUES(?,?,?,?)");
         $insert_product->execute([$name, $category, $price, $image]);

         $message[] = 'new product added!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');

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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" />
  <style>
    body {
      background-color: #1b1b1b;
      color: #fff;
      font-family: 'DM Sans', sans-serif;
      margin: 0;
      padding: 0;
    }

    section {
      max-width: 1200px;
      margin: 40px auto;
      padding: 2rem;
    }

    h3, h1 {
      text-align: center;
      color: #f5c518;
      margin-bottom: 25px;
    }

    form {
      background: #2c2c2c;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 40px;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }

    .box {
      width: 100%;
      padding: 12px 15px;
      margin: 12px 0;
      border: none;
      border-radius: 8px;
      background: #333;
      color: white;
      font-size: 16px;
    }

    .btn {
      background-color: #f5c518;
      color: #000;
      padding: 12px 20px;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      font-size: 16px;
      display: block;
      margin: 20px auto 0;
      width: 100%;
    }

    .btn:hover {
      background-color: #fff;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .box-container .box {
      background-color: #2e2e2e;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .box-container .box img {
      width: 100%;
      max-height: 200px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 12px;
    }

    .flex {
      display: flex;
      justify-content: space-between;
      color: #ccc;
      font-size: 15px;
      margin-bottom: 10px;
    }

    .name {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 12px;
      color: #fff;
    }

    .flex-btn {
      display: flex;
      justify-content: center;
      gap: 10px;
    }

    .option-btn,
    .delete-btn {
      padding: 10px 14px;
      border-radius: 8px;
      text-decoration: none;
      font-size: 14px;
      color: #fff;
      font-weight: bold;
    }

    .option-btn {
      background-color: #3498db;
    }

    .option-btn:hover {
      background-color: #2980b9;
    }

    .delete-btn {
      background-color: #e74c3c;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    .empty {
      text-align: center;
      color: #aaa;
      font-size: 18px;
    }
  </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<!-- Add product -->
<section>
  <form action="" method="POST" enctype="multipart/form-data">
    <h3>Add Product</h3>
    <input type="text" name="name" placeholder="Enter product name" maxlength="100" class="box" required>
    <input type="number" name="price" placeholder="Enter product price" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
    <select name="category" class="box" required>
      <option value="" disabled selected>Select category --</option>
      <option value="main dish">Main Dish</option>
      <option value="fast food">Fast Food</option>
      <option value="drinks">Drinks</option>
      <option value="desserts">Desserts</option>
    </select>
    <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
    <input type="submit" value="Add Product" name="add_product" class="btn">
  </form>
</section>

<!-- Show products -->
<section>
  <h1>Products</h1>
  <div class="box-container">
    <?php
    $show_products = $conn->prepare("SELECT * FROM `products`");
    $show_products->execute();
    if($show_products->rowCount() > 0){
      while($product = $show_products->fetch(PDO::FETCH_ASSOC)){
    ?>
    <div class="box">
      <img src="../uploaded_img/<?= $product['image']; ?>" alt="<?= $product['name']; ?>">
      <div class="flex">
        <div class="price">$<?= $product['price']; ?></div>
        <div class="category"><?= $product['category']; ?></div>
      </div>
      <div class="name"><?= $product['name']; ?></div>
      <div class="flex-btn">
        <a href="update_product.php?update=<?= $product['id']; ?>" class="option-btn">Update</a>
        <a href="products.php?delete=<?= $product['id']; ?>" class="delete-btn" onclick="return confirm('Delete this product?');">Delete</a>
      </div>
    </div>
    <?php }} else {
      echo '<p class="empty">No products added yet!</p>';
    } ?>
  </div>
</section>

</body>
</html>