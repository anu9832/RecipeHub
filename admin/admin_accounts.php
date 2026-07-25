<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
  header('location:admin_login.php');
  exit;
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
  $delete_admin->execute([$delete_id]);
  header('location:admin_accounts.php');
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

    .accounts {
      max-width: 1200px;
      margin: 0 auto;
      padding: 30px 20px;
    }

    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
    }

    .box {
      background-color: #2c2c2c;
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .box p {
      margin-bottom: 10px;
      font-size: 1rem;
    }

    .box span {
      color: #f5c518;
      font-weight: bold;
    }

    .btn,
    .option-btn,
    .delete-btn {
      display: inline-block;
      margin: 6px 4px 0 0;
      padding: 10px 16px;
      font-size: 0.9rem;
      font-weight: 600;
      text-decoration: none;
      border-radius: 10px;
      transition: all 0.3s ease;
      text-align: center;
    }

    .option-btn {
      background-color: #3498db;
      color: #fff;
    }

    .option-btn:hover {
      background-color: #2980b9;
    }

    .delete-btn {
      background-color: #e74c3c;
      color: #fff;
    }

    .delete-btn:hover {
      background-color: #c0392b;
    }

    .box:first-child {
      text-align: center;
      background-color: #f5c518;
      color: #1b1b1b;
    }

    .box:first-child a {
      margin-top: 10px;
      background-color: #fff;
      color: #1b1b1b;
    }

    .empty {
      text-align: center;
      color: #ccc;
      font-size: 1.1rem;
      margin-top: 40px;
    }

    .flex-btn {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
      margin-top: 10px;
    }
  </style>
</head>

<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="accounts">
    <h1 class="heading">Admins Account</h1>

    <div class="box-container">
      <div class="box">
        <p><strong>Register New Admin</strong></p>
        <a href="register_admin.php" class="option-btn">Register</a>
      </div>

      <?php
      $select_account = $conn->prepare("SELECT * FROM `admin`");
      $select_account->execute();
      if ($select_account->rowCount() > 0) {
        while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
      ?>
          <div class="box">
            <p>Admin ID: <span><?= $fetch_accounts['id']; ?></span></p>
            <p>Username: <span><?= $fetch_accounts['name']; ?></span></p>
            <div class="flex-btn">
              <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('Delete this account?');">Delete</a>
              <?php if ($fetch_accounts['id'] == $admin_id) : ?>
                <a href="update_profile.php" class="option-btn">Update</a>
              <?php endif; ?>
            </div>
          </div>
      <?php
        }
      } else {
        echo '<p class="empty">No admin accounts found!</p>';
      }
      ?>
    </div>
  </section>

</body>

</html>
