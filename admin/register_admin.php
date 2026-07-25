<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;
if(!$admin_id){
   header('location:admin_login.php');
}

$message = []; 

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);

   if($select_admin->rowCount() > 0){
      $message[] = 'Username already exists!';
   } else {
      if($pass != $cpass){
         $message[] = 'Confirm password does not match!';
      } else {
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'New admin registered!';
      }
   }
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
  <!-- Font Awesome & Google Fonts -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet" />

  
  <style>

    body {
      font-family: 'DM Sans', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--eerie-black, #0e0e0e);
      color: white;
    }


    .heading {
      font-family: 'Forum', cursive;
      font-size: 3rem;
      color: var(--gold-crayola, #f9c349);
      margin-bottom: 40px;
      text-align: center;
    }

      .form-container {
         max-width: 500px;
         background-color: #2c2c2c;
         margin: 50px auto;
         padding: 40px;
         border-radius: 16px;
         box-shadow: 0 4px 16px rgba(0,0,0,0.2);
      }

      .form-container h3 {
         font-size: 1.8rem;
         margin-bottom: 20px;
         text-align: center;
         color: #f5c518;
      }

      .form-container .box {
         width: 100%;
         padding: 12px 15px;
         margin-bottom: 15px;
         border-radius: 10px;
         border: 2px solid #555;
         background-color: #1b1b1b;
         color: #fff;
         font-size: 1rem;
      }

      .form-container .btn {
         width: 100%;
         background-color: #f5c518;
         color: #1b1b1b;
         padding: 12px;
         font-weight: bold;
         border-radius: 10px;
         cursor: pointer;
         border: none;
         transition: background 0.3s ease;
      }

      .form-container .btn:hover {
         background-color: #e0b014;
      }

      .message {
         background-color: #444;
         color: #f5c518;
         padding: 10px 20px;
         margin: 20px auto;
         max-width: 500px;
         border-radius: 8px;
         position: relative;
         text-align: center;
      }

      .message i {
         position: absolute;
         right: 15px;
         top: 50%;
         transform: translateY(-50%);
         cursor: pointer;
         color: #fff;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<?php
if (isset($message) && is_array($message)) {
   foreach ($message as $msg) {
      echo '<div class="message"><span>' . $msg . '</span><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>';
   }
}
?>

<section class="form-container">
   <form action="" method="POST">
      <h3>Register New Admin</h3>
      <input type="text" name="name" required placeholder="Enter username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Enter password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" required placeholder="Confirm password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Register Now" name="submit" class="btn">
   </form>
</section>

<script src="../js/admin_script.js"></script>
</body>
</html>
