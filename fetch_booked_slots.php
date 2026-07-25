<?php
include 'components/connect.php';

if (isset($_POST['selected_date'])) {
    $selected_date = $_POST['selected_date'];

    $stmt = $conn->prepare("SELECT time FROM reservation WHERE date_res = ?");
    $stmt->execute([$selected_date]);

    $times = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return as JSON array of booked times
    echo json_encode($times);
}
?>
