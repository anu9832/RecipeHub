<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
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
   <!-- Font Awesome -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet" />

   <!-- Custom CSS -->
   <style>
      body {
         font-family: 'DM Sans', sans-serif;
         background-color: #1b1b1b;
         color: #fff;
         margin: 0;
         padding: 0;
      }

      .heading {
         text-align: center;
         font-size: 2.2rem;
         color: #e4c590;
         margin: 2rem 0;
         text-transform: uppercase;
      }

      .messages .box-container {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
         gap: 2rem;
         padding: 0 2rem 4rem;
         max-width: 1300px;
         margin: auto;
      }

      .messages .box {
         background-color: #2c2c2c;
         border: 1px solid #3a3a3a;
         border-radius: 15px;
         padding: 2rem;
         box-shadow: 0 4px 12px rgba(0,0,0,0.4);
         transition: 0.3s;
      }

      .messages .box:hover {
         transform: translateY(-5px);
         border-color: #e4c590;
      }

      .messages .box p {
         margin-bottom: 1rem;
         font-size: 1rem;
         color: #eee;
      }

      .messages .box span {
         font-weight: bold;
         color: #e4c590;
      }

      .delete-btn {
         background-color: #e74c3c;
         padding: 0.6rem 1rem;
         color: #fff;
         border: none;
         text-decoration: none;
         border-radius: 8px;
         display: inline-block;
         margin-top: 1rem;
         font-weight: bold;
         transition: 0.3s;
      }

      .delete-btn:hover {
         background-color: #c0392b;
      }

      .empty {
         text-align: center;
         font-size: 1.2rem;
         color: #999;
         margin-top: 2rem;
      }
   </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="messages">
   <h1 class="heading">Admin Messages</h1>

   <div class="box-container">
      <?php
      $select_messages = $conn->prepare("SELECT * FROM `messages`");
      $select_messages->execute();
      if ($select_messages->rowCount() > 0) {
         while ($fetch_messages = $select_messages->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="box">
         <p><strong>Name:</strong> <span><?= $fetch_messages['name']; ?></span></p>
         <p><strong>Number:</strong> <span><?= $fetch_messages['number']; ?></span></p>
         <p><strong>Email:</strong> <span><?= $fetch_messages['email']; ?></span></p>
         <p><strong>Message:</strong> <span><?= $fetch_messages['message']; ?></span></p>
         <a href="messages.php?delete=<?= $fetch_messages['id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?');">Delete</a>
      </div>
      <?php
         }
      } else {
         echo '<p class="empty">You have no messages!</p>';
      }
      ?>
   </div>
</section>

<!-- JS File -->
<script src="../js/admin_script.js"></script>
</body>
</html>
