<?php
include '../components/connect.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
  header('location:admin_login.php');
  exit;
}
if (isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $status = $_POST['status'];
    $admin_reply = $_POST['admin_reply'];

    $stmt = $conn->prepare("UPDATE reservation SET status = ?, admin_reply = ? WHERE reserve_id = ?");
    $stmt->execute([$status, $admin_reply, $reservation_id]);
    $message[] = "Reservation updated!";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reservations - Admin</title>
  <link rel="stylesheet" href="../css/admin_style.css">
  <style>
    body {
      background: #0e0e0e;
      color: white;
      font-family: 'DM Sans', sans-serif;
    }
    .container {
      max-width: 1200px;
      margin: auto;
      padding: 40px 20px;
    }
    .heading {
      text-align: center;
      font-size: 3rem;
      color: #f9c349;
      margin-bottom: 2rem;
    }
    .box-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 20px;
    }
    .box {
      background: #1c1b1b;
      border: 1px solid #f9c349;
      border-radius: 12px;
      padding: 20px;
    }
    .box p {
      margin: 0.5rem 0;
      color: #ccc;
    }
    .box span {
      color: white;
      font-weight: bold;
    }
    .status {
      color: #00ff6e;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">
    <h1 class="heading">Manage Reservations</h1>
    <div class="box-container">

        <?php
        $reservations = $conn->prepare("SELECT * FROM reservation ORDER BY date_res DESC");
        $reservations->execute();
        if ($reservations->rowCount() > 0):
            while ($row = $reservations->fetch(PDO::FETCH_ASSOC)):
        ?>
        <div class="box">
            <p><strong>Name:</strong> <?= $row['name']; ?></p>
            <p><strong>Email:</strong> <?= $row['email']; ?></p>
            <p><strong>Phone:</strong> <?= $row['phone']; ?></p>
            <p><strong>Guests:</strong> <?= $row['no_of_guest']; ?></p>
            <p><strong>Date:</strong> <?= $row['date_res']; ?></p>
            <p><strong>Time:</strong> <?= $row['time']; ?></p>
            <p><strong>Suggestions:</strong> <?= $row['suggestions']; ?></p>
            <p><strong>Status:</strong> <span style="color:gold"><?= $row['status']; ?></span></p>

            <form action="" method="post">
                <input type="hidden" name="reservation_id" value="<?= $row['reserve_id']; ?>">
                <select name="status" required>
                    <option value="pending" <?= $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                    <option value="approved" <?= $row['status'] == 'approved' ? 'selected' : ''; ?>>Approve</option>
                    <option value="rejected" <?= $row['status'] == 'rejected' ? 'selected' : ''; ?>>Reject</option>
                </select>
                <textarea name="admin_reply" placeholder="Admin reply (optional)"><?= $row['admin_reply']; ?></textarea>
                <button type="submit" name="update_status" class="btn">Update</button>
            </form>
        </div>
        <?php endwhile; else: ?>
            <p class="empty">No reservations found.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>