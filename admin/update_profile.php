<?php
include '../components/connect.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;

// Fetch admin profile
$select_profile = $conn->prepare("SELECT * FROM `admin` WHERE id = ?");
$select_profile->execute([$admin_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Handle update form submission
if (isset($_POST['submit'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $old_pass = sha1($_POST['old_pass']);
   $new_pass = sha1($_POST['new_pass']);
   $confirm_pass = sha1($_POST['confirm_pass']);

   if ($old_pass != $fetch_profile['password']) {
      $message[] = 'Old password is incorrect!';
   } elseif ($new_pass != $confirm_pass) {
      $message[] = 'New passwords do not match!';
   } else {
      $update_admin = $conn->prepare("UPDATE `admin` SET name = ?, password = ? WHERE id = ?");
      $update_admin->execute([$name, $new_pass, $admin_id]);
      $message[] = 'Profile updated successfully!';
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
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" />

  <!-- Custom Grilli-like admin style -->
  <style>
    body {
      margin: 0;
      font-family: 'DM Sans', sans-serif;
      background-color: #1b1b1b;
      color: #fff;
    }

    .form-section {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding-top: 60px;
    }

    .form-container {
      background-color: #2e2e2e;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 8px 24px rgba(0,0,0,0.25);
      width: 100%;
      max-width: 480px;
      text-align: center;
    }

    .form-container h3 {
      font-size: 26px;
      color: #f5c518;
      margin-bottom: 20px;
    }

    .form-container .box {
      width: 100%;
      padding: 12px 16px;
      margin-bottom: 18px;
      border: none;
      border-radius: 10px;
      background-color: #444;
      color: #fff;
      font-size: 16px;
    }

    .form-container .btn {
      background-color: #f5c518;
      color: #000;
      padding: 12px 30px;
      border-radius: 10px;
      font-weight: bold;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }

    .form-container .btn:hover {
      background-color: #fff;
      color: #000;
    }
  </style>
</head>
<body>

  <?php include '../components/admin_header.php'; ?>

  <section class="form-section">
    <form class="form-container" action="" method="POST">
      <h3>Update Profile</h3>
      <input type="text" name="name" class="box" placeholder="<?= htmlspecialchars($fetch_profile['name']) ?>" maxlength="20" oninput="this.value=this.value.replace(/\s/g,'')" />
      <input type="password" name="old_pass" class="box" placeholder="Enter your old password" maxlength="20" oninput="this.value=this.value.replace(/\s/g,'')" />
      <input type="password" name="new_pass" class="box" placeholder="Enter your new password" maxlength="20" oninput="this.value=this.value.replace(/\s/g,'')" />
      <input type="password" name="confirm_pass" class="box" placeholder="Confirm your new password" maxlength="20" oninput="this.value=this.value.replace(/\s/g,'')" />
      <input type="submit" name="submit" class="btn" value="Update Now" />
    </form>
  </section>

</body>
</html>