<?php
include 'components/connect.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header('location:login.php');
  exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user email
$get_user = $conn->prepare("SELECT email FROM users WHERE id = ?");
$get_user->execute([$user_id]);
$user_email = $get_user->fetchColumn();

// Default selected date (today)
$selectedDate = $_POST['reservation_date'] ?? date('Y-m-d');

// Handle AJAX request to fetch booked time slots for selected date
if (isset($_POST['action']) && $_POST['action'] === 'fetch_slots' && !empty($_POST['date'])) {
  $date = $_POST['date'];
  $stmt = $conn->prepare("SELECT time FROM reservation WHERE date_res = ?");
  $stmt->execute([$date]);
  $bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);
  echo json_encode($bookedSlots);
  exit;
}

// Handle reservation form submission
$message = $success = [];

if (isset($_POST['submit_reservation'])) {
    // Sanitize inputs
    $name = trim(filter_var($_POST['name'] ?? '', FILTER_SANITIZE_STRING));
    $phone = trim(filter_var($_POST['phone'] ?? '', FILTER_SANITIZE_STRING));
    $guests = (int)($_POST['no_of_guest'] ?? 0);
    $date = $_POST['reservation_date'] ?? null;
    $time = $_POST['reservation_time'] ?? null;
    $theme = $_POST['theme'] ?? '';
    $custom_message = trim($_POST['custom_message'] ?? '');

    // Validate required fields
    if (!$date || !$time) {
        $message[] = 'Please select both date and time for reservation.';
    }
    if (empty($name)) {
        $message[] = 'Please enter your name.';
    }
    if (empty($phone)) {
        $message[] = 'Please enter your phone number.';
    }
    if ($guests < 1) {
        $message[] = 'Please enter a valid number of guests.';
    }
    if (empty($theme) && empty($custom_message)) {
        $message[] = 'Please select a theme or write a custom message.';
    }

    if (empty($message)) {
        // Check if slot is already booked
        $check_slot = $conn->prepare("SELECT * FROM reservation WHERE date_res = ? AND time = ?");
        $check_slot->execute([$date, $time]);

        if ($check_slot->rowCount() > 0) {
            $message[] = 'This time slot is already booked!';
        } else {
            $suggestions = $theme ?: $custom_message;
            $insert = $conn->prepare("INSERT INTO reservation (user_id, name, email, phone, no_of_guest, date_res, time, suggestions, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
            $insert->execute([$user_id, $name, $user_email, $phone, $guests, $date, $time, $suggestions]);

            if ($theme) {
                $success[] = 'Reservation successful! Thanks for booking!';
            } else {
                $success[] = 'Reservation submitted! Admin will respond shortly.';
            }
        }
    }
}

// Predefined time slots
$times = ['08:00am','09:00am','10:00am','11:00am','12:00pm','01:00pm','02:00pm','03:00pm','04:00pm','05:00pm','06:00pm','07:00pm','08:00pm','09:00pm'];

// Fetch booked slots initially for $selectedDate so initial load has correct seat map
$stmt = $conn->prepare("SELECT time FROM reservation WHERE date_res = ?");
$stmt->execute([$selectedDate]);
$bookedSlots = $stmt->fetchAll(PDO::FETCH_COLUMN);
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
  <meta name="description" content="This is a Restaurant html template made by gayatri">
  
  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./fav1.svg" type="image/svg+xml">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style.css">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/img5.jpg">
  <link rel="preload" as="image" href="./assets/images/img21.jpg">
  <link rel="preload" as="image" href="./assets/images/img3.avif">

</head>
<body id="top">

  <!-- 
    - #PRELOADER
  -->

  <div class="preload" data-preaload>
    <div class="circle"></div>
    <p class="text">Recipe Hub</p>
  </div>

  <!-- 
    - #TOP BAR
  -->

  <div class="topbar">
    <div class="container">
      <address class="topbar-item">
        <div class="icon">
          <ion-icon name="location-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">
        Recipe Hub, Chandni Chowk, Delhi – 110006 
        </span>
      </address>
      <div class="separator"></div>
      <div class="topbar-item item-2">
        <div class="icon">
          <ion-icon name="time-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">Daily : 8.00 am to 11.30 pm</span>
      </div>
      <a href="tel:+91 67899 12345" class="topbar-item link">
        <div class="icon">
          <ion-icon name="call-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">+91 67899 12345</span>
      </a>
      <div class="separator"></div>
      <a href="mailto:contact@recipehubdelhi.com" class="topbar-item link">
        <div class="icon">
          <ion-icon name="mail-outline" aria-hidden="true"></ion-icon>
        </div>
        <span class="span">contact@recipehubdelhi.com</span>
      </a>
    </div>
  </div>

  <?php include 'components/user_header.php'; ?>

  <main>
    <section class="reservation-container" aria-label="Reservation form section" style="
    margin-top: 200px;">

      <h2 class="headline-1">Book a Table</h2>

      <?php if (!empty($message)): ?>
        <div class="alert">
          <?php foreach ($message as $msg): ?>
            <p><?=htmlspecialchars($msg)?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($success)): ?>
        <div class="alert success">
          <?php foreach ($success as $msg): ?>
            <p><?=htmlspecialchars($msg)?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <form method="POST" id="reservationForm" autocomplete="off" novalidate>
        <input type="text" name="name" placeholder="Name *" value="<?=htmlspecialchars($_POST['name'] ?? '')?>" required />
        <input type="tel" name="phone" placeholder="Phone *" value="<?=htmlspecialchars($_POST['phone'] ?? '')?>" required />
        <input type="number" name="no_of_guest" placeholder="No. of Guests *" min="1" max="20" value="<?=htmlspecialchars($_POST['no_of_guest'] ?? '')?>" required />

        <label for="reservation_date">Select Date *</label>
        <input type="date" name="reservation_date" id="reservation_date" value="<?=htmlspecialchars($selectedDate)?>" min="<?=date('Y-m-d')?>" required />

        <label for="reservation_time">Select Time *</label>
        <div id="seat-map" class="seat-map" role="list" aria-label="Time slots selection">
          <?php foreach ($times as $time_slot): 
            $isTaken = in_array($time_slot, $bookedSlots); ?>
            <div 
              class="seat <?= $isTaken ? 'taken' : '' ?>" 
              tabindex="<?= $isTaken ? '-1' : '0' ?>" 
              role="option" 
              aria-selected="false" 
              data-time="<?=htmlspecialchars($time_slot)?>"
              aria-disabled="<?= $isTaken ? 'true' : 'false' ?>"
            >
              <?=htmlspecialchars($time_slot)?>
            </div>
          <?php endforeach; ?>
        </div>

        <input type="hidden" name="reservation_time" id="reservation_time" required />

        <fieldset class="themes" aria-label="Select occasion theme">
          <legend>Choose Theme *</legend>
          <label>
            <input type="radio" name="theme" value="Birthday" <?= (($_POST['theme'] ?? '') === 'Birthday') ? 'checked' : '' ?> />
            Birthday
          </label>
          <label>
            <input type="radio" name="theme" value="Anniversary" <?= (($_POST['theme'] ?? '') === 'Anniversary') ? 'checked' : '' ?> />
            Anniversary
          </label>
          <label>
            <input type="radio" name="theme" value="Engagement" <?= (($_POST['theme'] ?? '') === 'Engagement') ? 'checked' : '' ?> />
            Engagement
          </label>
          <label>
            <input type="radio" name="theme" value="Others" <?= (($_POST['theme'] ?? '') === 'Others') ? 'checked' : '' ?> />
            Others
          </label>
        </fieldset>

        <textarea name="custom_message" id="custom_message" rows="4" placeholder="Write custom message here..."><?=htmlspecialchars($_POST['custom_message'] ?? '')?></textarea>

        <button type="submit" name="submit_reservation">Book Now</button>
      </form>
    </section>
  </main>
  <footer class="footer section has-bg-image text-center"
    style="background-image: url('./assets/images/footer-bg.jpg')">
    <div class="container">

      <div class="footer-top grid-list">

        <div class="footer-brand has-before has-after">

          <a href="#" class="logo">
            <img src="./assets/images/logo 1.png" width="200" height="200" loading="lazy" alt="crave haven home">
          </a>

          <address class="body-4">
       Recipe Hub, Chandni Chowk, Delhi – 110006
          </address>

          <a href="mailto:contact@recipehubdelhi.com" class="body-4 contact-link">contact@recipehubdelhi.com</a>

          <a href="tel:+91 67899 12345" class="body-4 contact-link">Booking Request : +91 67899 12345</a>

          <p class="body-4">
            Open : 08:00 am - 11:30 pm
          </p>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>
        </div>
        <ul class="footer-list">

          <li>
            <a href="index.php" class="label-2 footer-link hover-underline">Home</a>
          </li>

          <li>
            <a href="menu.php" class="label-2 footer-link hover-underline">Menus</a>
          </li>

          <li>
            <a href="index.php#about" class="label-2 footer-link hover-underline">About Us</a>
          </li>
          
          <li>
            <a href="index.php#reservation" class="label-2 footer-link hover-underline">Contact</a>
          </li>

        </ul>

        <ul class="footer-list">

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Facebook</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Instagram</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Twitter</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Youtube</a>
          </li>

          <li>
            <a href="#" class="label-2 footer-link hover-underline">Google Map</a>
          </li>

        </ul>

      </div>

      <div class="footer-bottom">

        <p class="copyright">
          &copy; 2025 Recipe Hub. All Rights Reserved | Designed with flavor, crafted with care <a href="https://github.com/anu9832"
            target="_blank" class="link">Anushuya</a>
        </p>

      </div>

    </div>
  </footer>
  <!-- 
    - #BACK TO TOP
  -->
  <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>
<style>
    body {
      background: #0e0e0e;
      font-family: 'DM Sans', sans-serif;
      color: white;
    }
    .reservation-container {
      max-width: 800px;
      margin: 150px auto 60px;
      padding: 30px;
      background-color: #1a1a1a;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.4);
    }
    .headline-1 {
      color: #f9c349;
      text-align: center;
      margin-bottom: 30px;
    }
    form input, form select, form textarea {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      background: #2a2a2a;
      color: white;
      border: 1px solid #444;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
    }
    .themes label {
      display: inline-block;
      margin-right: 15px;
      margin-bottom: 10px;
      cursor: pointer;
      font-size: 1.1rem;
      user-select: none;
    }
    .themes input[type="radio"] {
      margin-right: 6px;
      cursor: pointer;
    }
    .seat-map {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 40px;
    }
    .seat {
      background: #2ecc71;
      color: #000;
      text-align: center;
      padding: 10px;
      border-radius: 6px;
      font-weight: bold;
      user-select: none;
      cursor: pointer;
      transition: background-color 0.3s ease;
      user-select: none;
    }
    .seat.taken {
      background: #e74c3c;
      color: white;
      text-decoration: line-through;
      cursor: not-allowed;
    }
    .seat.selected {
      background: #f9c349;
      color: black;
    }
    button {
      background: #f9c349;
      color: black;
      padding: 12px 20px;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
      margin-top: 10px;
      width: 100%;
    }
    button:hover {
      background: white;
      color: black;
    }
    .alert {
      background: #292929;
      padding: 12px 15px;
      border-left: 5px solid #f9c349;
      margin-bottom: 20px;
      border-radius: 6px;
      user-select: none;
    }
    .alert.success {
      border-left-color: #2ecc71;
      color: #2ecc71;
    }
  </style>
  <script>
   document.addEventListener('DOMContentLoaded', () => {
  const seatMap = document.getElementById('seat-map');
  const timeInput = document.getElementById('reservation_time');
  const themeRadios = document.querySelectorAll('input[name="theme"]');
  const customMessage = document.getElementById('custom_message');
  const reservationDate = document.getElementById('reservation_date');
  const form = document.querySelector('form'); // Adjust if you have multiple forms

  // Get all focusable input/select/textarea elements inside form except hidden and disabled
  const inputs = Array.from(form.querySelectorAll('input, select, textarea'))
    .filter(el => el.type !== 'hidden' && !el.disabled && el.offsetParent !== null);

  // Try to get phone number input by common selectors
  const phoneInput = form.querySelector('input[type="tel"], input[name="phone"], input[id="phone"]');
  
  // Seat selection logic
  seatMap.addEventListener('click', (e) => {
    const seat = e.target.closest('.seat');
    if (!seat || seat.classList.contains('taken')) return;

    // Remove previous selection
    const prevSelected = seatMap.querySelector('.seat.selected');
    if (prevSelected) {
      prevSelected.classList.remove('selected');
      prevSelected.setAttribute('aria-selected', 'false');
    }

    // Select clicked seat
    seat.classList.add('selected');
    seat.setAttribute('aria-selected', 'true');
    timeInput.value = seat.getAttribute('data-time');
  });

  // Keyboard accessibility for seats (Enter key triggers click)
  seatMap.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      e.target.click();
    }
  });

  // Enter key on inputs moves focus to next empty input instead of submitting
  inputs.forEach((input, i) => {
    input.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();

        // Find next empty input to focus
        let foundNextEmpty = false;
        for (let j = i + 1; j < inputs.length; j++) {
          if (!inputs[j].value.trim()) {
            inputs[j].focus();
            foundNextEmpty = true;
            break;
          }
        }
        if (!foundNextEmpty) {
          // If no next empty, focus stays or can blur
          input.blur();
        }
      }
    });
  });

  // When a theme radio is selected, clear custom message
  themeRadios.forEach(radio => {
    radio.addEventListener('change', () => {
      if (radio.checked) {
        customMessage.value = '';
      }
    });
  });

  // When custom message typed, clear theme radios
  customMessage.addEventListener('input', () => {
    if (customMessage.value.trim() !== '') {
      themeRadios.forEach(radio => radio.checked = false);
    }
  });

  // Fetch booked slots on date change and update seat map
  reservationDate.addEventListener('change', async () => {
    const selectedDate = reservationDate.value;
    timeInput.value = '';
    const prevSelected = seatMap.querySelector('.seat.selected');
    if (prevSelected) prevSelected.classList.remove('selected');

    if (!selectedDate) return;

    try {
      const response = await fetch('', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
          action: 'fetch_slots',
          date: selectedDate
        })
      });
      const bookedSlots = await response.json();

      [...seatMap.children].forEach(seat => {
        const time = seat.getAttribute('data-time');
        if (bookedSlots.includes(time)) {
          seat.classList.add('taken');
          seat.setAttribute('aria-disabled', 'true');
          seat.tabIndex = -1;
        } else {
          seat.classList.remove('taken');
          seat.setAttribute('aria-disabled', 'false');
          seat.tabIndex = 0;
        }
      });
    } catch (err) {
      console.error('Error fetching booked slots:', err);
    }
  });

  // Initial fetch on page load
  reservationDate.dispatchEvent(new Event('change'));

  // Form submission handler with validation and clear
  form.addEventListener('submit', e => {
    // Validate all inputs filled
    for (const input of inputs) {
      if (!input.value.trim()) {
        alert('Please fill all the fields.');
        input.focus();
        e.preventDefault();
        return;
      }
    }

    // Validate phone number exactly 10 digits
    if (phoneInput) {
      const phoneVal = phoneInput.value.trim();
      if (!/^\d{10}$/.test(phoneVal)) {
        alert('Phone number must be exactly 10 digits.');
        phoneInput.focus();
        e.preventDefault();
        return;
      }
    }

    // Validate guests between 1 and 100
    const guestsInput = inputs.find(i => /guests?/i.test(i.name) || /guests?/i.test(i.id));
    if (guestsInput) {
      const guestsNum = parseInt(guestsInput.value, 10);
      if (isNaN(guestsNum) || guestsNum < 1 || guestsNum > 100) {
        alert('Number of guests must be between 1 and 100.');
        guestsInput.focus();
        e.preventDefault();
        return;
      }
    }

    // Clear form and UI after submit (delay so submission goes through)
    setTimeout(() => {
      form.reset();

      // Clear seat selection and time input
      const selectedSeat = seatMap.querySelector('.seat.selected');
      if (selectedSeat) selectedSeat.classList.remove('selected');
      timeInput.value = '';
    }, 10);
  });
});

  </script>
<!-- custom js file link  -->
 <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script src="./assets/js/script.js"></script>
</body>
</html>
