<?php
include '../components/connect.php';
session_start();

if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'Incorrect username or password!';
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
  <title>Recipe Hub - Cravings Met, Taste Elevated!</title>
  <meta name="title" content="Recipe Hub - Cravings Met, Taste Elevated!">
  <meta name="description" content="This is a Restaurant html template made by anushuya">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./fav1.svg" type="image/svg+xml">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  
  <!-- Google Fonts + Grilli Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- Grilli CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">

  <style>
    body {
      background-color: var(--eerie-black);
      font-family: 'DM Sans', sans-serif;
    }

    .form-section {
      margin-top: 140px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .admin-login-form {
      max-width: 500px;
      width: 100%;
      background-color: var(--smoky-black-2);
      padding: 40px;
      border-radius: 16px;
      border: 1px solid var(--gold-crayola);
      text-align: center;
    }

    .admin-login-form h3 {
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--gold-crayola);
    }

    .admin-login-form p {
      color: var(--white);
      font-size: 1rem;
      margin-bottom: 20px;
    }

    .admin-login-form span {
      color: var(--gold-crayola);
      font-weight: bold;
    }

    .admin-login-form .box {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      background-color: var(--smoky-black);
      color: white;
      border: 1px solid var(--gold-crayola);
      border-radius: 8px;
      font-size: 1rem;
    }

    .admin-login-form .btn {
      background-color: var(--gold-crayola);
      color: black;
      padding: 12px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      border: none;
      width: 100%;
      margin-top: 15px;
    }

    .admin-login-form .btn:hover {
      background-color: var(--white);
    }

    .message {
      background: #e74c3c;
      color: white;
      padding: 10px;
      margin: 15px auto;
      max-width: 500px;
      text-align: center;
      border-radius: 8px;
      position: relative;
    }

    .message i {
      position: absolute;
      right: 15px;
      top: 12px;
      cursor: pointer;
    }
  </style>
</head>

<body>

<?php
if (!empty($message)) {
  foreach ($message as $msg) {
    echo '<div class="message">
      <span>' . $msg . '</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
    </div>';
  }
}
?>

<section class="form-section">
  <form action="" method="POST" class="admin-login-form">
    <h3>Admin Login</h3>
    <p>Default username: <span>admin</span> | Password: <span>111</span></p>
    <input type="text" name="name" required placeholder="Enter your username" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="pass" required placeholder="Enter your password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="Login Now" name="submit" class="btn">
  </form>
</section>


</body>
</html>