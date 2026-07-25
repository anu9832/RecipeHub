<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';
// Handle contact form submission
if (isset($_POST['submit_contact'])) {
  $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $number = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
  $msg = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

  $insert_message = $conn->prepare("INSERT INTO `messages` (name, email, number, message) VALUES (?, ?, ?, ?)");
  $insert_message->execute([$name, $email, $number, $msg]);

  // Set the global $message array to be used in header
  $message[] = 'Your message has been sent successfully!';
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
  <main>
    <article>
    <?php include 'components/user_header.php'; ?>
      <!-- 
        - #HERO
      -->

      <section class="hero text-center" aria-label="home" id="home">

        <ul class="hero-slider" data-hero-slider>

          <li class="slider-item active" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./assets/images/img51.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">Tradational & Hygine</p>

            <h1 class="display-1 hero-title slider-reveal">
              Delicious moments  <br>
              One pale at a time
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="menu.php" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./assets/images/img31.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">delightful experience</p>

            <h1 class="display-1 hero-title slider-reveal">
              Where every bite <br>
              tells a story
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="menu.php" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

          <li class="slider-item" data-hero-slider-item>

            <div class="slider-bg">
              <img src="./assets/images/img32.jpg" width="1880" height="950" alt="" class="img-cover">
            </div>

            <p class="label-2 section-subtitle slider-reveal">amazing & delicious</p>

            <h1 class="display-1 hero-title slider-reveal">
              Savor the  <br>
              flavor of life
            </h1>

            <p class="body-2 hero-text slider-reveal">
              Come with family & feel the joy of mouthwatering food
            </p>

            <a href="menu.php" class="btn btn-primary slider-reveal">
              <span class="text text-1">View Our Menu</span>

              <span class="text text-2" aria-hidden="true">View Our Menu</span>
            </a>

          </li>

        </ul>

        <button class="slider-btn prev" aria-label="slide to previous" data-prev-btn>
          <ion-icon name="chevron-back"></ion-icon>
        </button>

        <button class="slider-btn next" aria-label="slide to next" data-next-btn>
          <ion-icon name="chevron-forward"></ion-icon>
        </button>

        <a href="reservation.php" class="hero-btn has-after">
          <img src="./assets/images/hero-icon.png" width="48" height="48" alt="booking icon">

          <span class="label-2 text-center span">Book A Table</span>
        </a>

      </section>

      <!-- 
        - #SERVICE
      -->

      <section class="section service bg-black-10 text-center" aria-label="service">
        <div class="container">

          <p class="section-subtitle label-2">Flavors For Royalty</p>

          <h2 class="headline-1 section-title">We Offer Top Notch</h2>

          <p class="section-text">
           We use only the best, top-notch ingredients in every dish we prepare—ensuring exceptional flavor, freshness, and quality every time.

          </p>

          <ul class="grid-list">

            <li>
              <div class="service-card">

                <a href="#" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./assets/images/service11.jpg" width="285" height="336" loading="lazy" alt="Breakfast"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="menu.php">Breakfast</a>
                  </h3>

                  <a href="menu.php" class="btn-text hover-underline label-2">View Menu</a>

                </div>

              </div>
            </li>

            <li>
              <div class="service-card">

                <a href="#" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./assets/images/service16.jpg" width="285" height="336" loading="lazy" alt="Appetizers"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="menu.php">Appetizers</a>
                  </h3>

                  <a href="menu.php" class="btn-text hover-underline label-2">View Menu</a>

                </div>

              </div>
            </li>

            <li>
              <div class="service-card">

                <a href="#" class="has-before hover:shine">
                  <figure class="card-banner img-holder" style="--width: 285; --height: 336;">
                    <img src="./assets/images/service14.jpg" width="285" height="336" loading="lazy" alt="Drinks"
                      class="img-cover">
                  </figure>
                </a>

                <div class="card-content">

                  <h3 class="title-4 card-title">
                    <a href="menu.php">Drinks</a>
                  </h3>

                  <a href="menu.php" class="btn-text hover-underline label-2">View Menu</a>

                </div>

              </div>
            </li>

          </ul>

          <img src="./assets/images/shape-1.png" width="246" height="412" loading="lazy" alt="shape"
            class="shape shape-1 move-anim">
          <img src="./assets/images/shape-2.png" width="343" height="345" loading="lazy" alt="shape"
            class="shape shape-2 move-anim">

        </div>
      </section>





      <!-- 
        - #ABOUT
      -->

      <section class="section about text-center" aria-labelledby="about-label" id="about">
        <div class="container">

          <div class="about-content">

            <p class="label-2 section-subtitle" id="about-label">Our Story</p>

            <h2 class="headline-1 section-title">Where Taste Meets Tradition</h2>

            <p class="section-text">
            Nestled in the heart of Delhi, Recipe Hub offers a unique dining experience where every dish blends local roots with global inspiration. Our chefs craft flavorful creations with heart and creativity, honoring traditional recipes while adding a modern touch. Enjoy live recipe showcases, seasonal menus, and personalized dishes made just for you. At Recipe Hub, every meal is a warm, memorable celebration of food.
            </p>

            <div class="contact-label">Book Through Call</div>

            <a href="tel:+91 67899 12345" class="body-1 contact-number hover-underline">+91 67899 12345</a>

          
          </div>

          <figure class="about-banner">

            <img src="./assets/images/about-banner1.webp" width="570" height="570" loading="lazy" alt="about banner"
              class="w-100" data-parallax-item data-parallax-speed="1">

            <div class="abs-img abs-img-1 has-before" data-parallax-item data-parallax-speed="1.75">
              <img src="./assets/images/about-abs1-image.jpg" width="285" height="285" loading="lazy" alt=""
                class="w-100">
            </div>

            <div class="abs-img abs-img-2 has-before">
              <img src="./assets/images/badge-2.png" width="133" height="134" loading="lazy" alt="">
            </div>

          </figure>

          <img src="./assets/images/shape-3.png" width="197" height="194" loading="lazy" alt="" class="shape">

        </div>
      </section>





      <!-- 
        - #SPECIAL DISH
      -->

      <section class="special-dish text-center" aria-labelledby="dish-label">

        <div class="special-dish-banner">
          <img src="./assets/images/specialdish1.jpg" width="940" height="900" loading="lazy" alt="special dish"
            class="img-cover">
        </div>

        <div class="special-dish-content bg-black-10">
          <div class="container">

            <img src="./assets/images/badge-1.png" width="28" height="41" loading="lazy" alt="badge" class="abs-img">

            <p class="section-subtitle label-2">Special Dish</p>

            <h2 class="headline-1 section-title">Tandoori Chicken</h2>

            <p class="section-text">
             Tandoori Chicken is a classic Indian delicacy where tender chicken pieces are marinated in a blend of yogurt, lemon juice, and bold spices like cumin, coriander, and Kashmiri chili. The marination process infuses the meat with flavor and keeps it juicy during cooking. Skewered and roasted in a traditional clay tandoor, the chicken develops a smoky char and a slightly crisp edge while remaining succulent inside. A brush of ghee enhances the richness, and a sprinkle of chaat masala adds a zesty finish. Served sizzling hot, this dish delivers vibrant flavor with every bite — smoky, spicy, and utterly irresistible.
            </p>

            <div class="wrapper">
              <del class="del body-3">200.00/-</del>

              <span class="span body-1">175.00/-</span>
            </div>

            <a href="menu.php" class="btn btn-primary">
              <span class="text text-1">View All Menu</span>

              <span class="text text-2" aria-hidden="true">View All Menu</span>
            </a>

          </div>
        </div>

        <img src="./assets/images/shape-4.png" width="179" height="359" loading="lazy" alt="" class="shape shape-1">

        <img src="./assets/images/shape-9.png" width="351" height="462" loading="lazy" alt="" class="shape shape-2">

      </section>

      <!-- 
        - #TESTIMONIALS
      -->

      <section class="section testi text-center has-bg-image"
        style="background-image: url('./assets/images/testimonial11.jpg')" aria-label="testimonials">
        <div class="container">

          <div class="quote">”</div>

          <p class="headline-2 testi-text">
         “Recipe Hub doesn’t just serve food, it serves stories on a plate.”
          </p>

          <div class="wrapper">
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="separator"></div>
          </div>

          <div class="profile">
            <img src="./assets/images/testi1.avif" width="100" height="100" loading="lazy" alt="Aarav Sinha"
              class="img">

            <p class="label-2 profile-name">Neha Rathore -Food Blogger</p>
          </div>

        </div>
      </section>


      <!-- 
        - #RESERVATION 
      -->

      <section class="reservation" id="reservation">
  <div class="container">

    <div class="form reservation-form bg-black-10" style="display: flex; gap: 2rem; flex-wrap: wrap; padding: 2rem;">

      <!-- Left side: Contact Info -->
      <div class="form-left"  style="background-image: url('./assets/images/form-pattern.png')">
        <h2 class="headline-1 text-center" style="margin-bottom: 1rem;">Contact Us</h2>

        <p class="contact-label" style="font-weight: 600;">Reach out to us for reservations and support:</p>
       <a href="tel:+91 67899 12345" class="body-1 contact-number hover-underline">+91 67899 12345</a><br>

        <!-- Centered Location & Timings -->
        <div style="text-align: center;">
          <p class="contact-label" style="font-weight: 600;">Location</p>
          <address class="body-4" style="font-style: normal; line-height: 1.4; margin-bottom: 1rem;">
           Recipe Hub, Chandni Chowk<br> Delhi – 110006
          </address>

          <p class="contact-label" style="font-weight: 600;">Lunch Time</p>
          <p class="body-4" style="margin-bottom: 1rem;">Monday to Sunday <br> 11:00 am - 3:30 pm</p>

          <p class="contact-label" style="font-weight: 600;">Dinner Time</p>
          <p class="body-4">Monday to Sunday <br> 05:00 pm - 11:30 pm</p>
        </div>
      </div>

      <!-- Right side: Feedback form -->
   <div class="form-right" style="flex: 1; min-width: 280px;">
  <h2 class="headline-1 text-center" style="margin-bottom: 1rem;">Feedback</h2>

  <form action="" method="post" class="contact-form">
    <input type="text" name="name" placeholder="Your Name" autocomplete="off" class="input-field" required>

    <input type="email" name="email" placeholder="Your Email" autocomplete="off" class="input-field" required>

    <input type="tel" name="phone" placeholder="Phone Number" autocomplete="off" class="input-field"
      pattern="[0-9]{10}" maxlength="10" required
      oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">

    <textarea name="message" placeholder="Your Feedback" autocomplete="off" class="input-field" required></textarea>

    <button type="submit" name="submit_contact" class="btn btn-secondary" style="width: 100%; margin-top: 1rem;">
      <span class="text text-1">Send Feedback</span>
      <span class="text text-2" aria-hidden="true">Send Feedback</span>
    </button>
  </form>
</div>


    </div>

  </div>
</section>




      <!-- 
        - #FEATURES
      -->

      <section class="section features text-center" aria-label="features">
        <div class="container">

          <p class="section-subtitle label-2">Why Choose Us</p>

          <h2 class="headline-1 section-title">Our Strength</h2>

          <ul class="grid-list">

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./assets/images/features-icon-1.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Hygienic Food</h3>

                <p class="label-1 card-text">Serving delicious meals crafted with the highest standards of hygiene for your health and satisfaction.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./assets/images/features-icon-2.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Fresh Environment</h3>

                <p class="label-1 card-text">Enjoy your dining experience in a fresh, clean, and welcoming environment designed for your comfort.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./assets/images/features-icon-3.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Skilled Chefs</h3>

                <p class="label-1 card-text">Our skilled chefs bring passion and expertise to every dish, ensuring exceptional taste and quality.</p>

              </div>
            </li>

            <li class="feature-item">
              <div class="feature-card">

                <div class="card-icon">
                  <img src="./assets/images/features-icon-4.png" width="100" height="80" loading="lazy" alt="icon">
                </div>

                <h3 class="title-2 card-title">Event & Party</h3>

                <p class="label-1 card-text">Perfect venue for unforgettable events and parties, tailored to make your celebrations truly special.</p>

              </div>
            </li>

          </ul>

          <img src="./assets/images/shape-7.png" width="208" height="178" loading="lazy" alt="shape"
            class="shape shape-1">

          <img src="./assets/images/shape-8.png" width="120" height="115" loading="lazy" alt="shape"
            class="shape shape-2">

        </div>
      </section>





      <!-- 
        - #EVENT
      -->

      <section class="section event bg-black-10" aria-label="event">
        <div class="container">

          <p class="section-subtitle label-2 text-center">Recent Updates</p>

          <h2 class="section-title headline-1 text-center">Upcoming Event</h2>

          <ul class="grid-list">

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./assets/images/event12.jpg" width="350" height="450" loading="lazy"
                    alt="Taste the true essence of tradition and innovation at Recipe Hub." class="img-cover">

                  <time class="publish-date label-2" datetime="2025-05-29">29/05/2025</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Where Flavor Comes Alive</p>

                  <h3 class="card-title title-2 text-center">
                Taste the true essence of tradition and innovation at Recipe Hub.
                  </h3>
                </div>

              </div>
            </li>

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./assets/images/event13.jpg" width="350" height="450" loading="lazy"
                    alt="Fresh, wholesome meals crafted for a nourishing lifestyle.." class="img-cover">

                  <time class="publish-date label-2" datetime="2025-06-10">10/06/2025</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Good Food, Good Life</p>

                  <h3 class="card-title title-2 text-center">
                Fresh, wholesome meals crafted for a nourishing lifestyle.
                  </h3>
                </div>

              </div>
            </li>

            <li>
              <div class="event-card has-before hover:shine">

                <div class="card-banner img-holder" style="--width: 350; --height: 450;">
                  <img src="./assets/images/event14.webp" width="350" height="450" loading="lazy"
                    alt="Savor timeless flavors passed down through generations, lovingly brought to life in every dish." class="img-cover">

                  <time class="publish-date label-2" datetime="2025-07-30">30/07/2025</time>
                </div>

                <div class="card-content">
                  <p class="card-subtitle label-2 text-center">Tradition on a Plate</p>

                  <h3 class="card-title title-2 text-center">
                  Savor timeless flavors passed down through generations, lovingly brought to life in every dish.
                  </h3>
                </div>

              </div>
            </li>

          </ul>
        </div>
      </section>

</article>
</main>

 <!-- 
    - #FOOTER
  -->

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

<!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  <script>
  const userIcon = document.getElementById('user-icon');
  const profileBox = document.getElementById('profile-box');

  userIcon.addEventListener('click', () => {
    profileBox.style.display = profileBox.style.display === 'block' ? 'none' : 'block';
  });

  // Optional: Click outside to close
  document.addEventListener('click', function (e) {
    if (!userIcon.contains(e.target) && !profileBox.contains(e.target)) {
      profileBox.style.display = 'none';
    }
  });
</script>


</body>
</html>
