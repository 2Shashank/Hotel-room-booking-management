<?php
session_start();
if (!isset($_SESSION["user"])) {
   header("Location: login.php");
}
 require_once ("database.php");

$sql = "SELECT address from Hotel";

$result = mysqli_query($conn, $sql);
$loc = mysqli_fetch_assoc($result);

$HotelName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Name as Hotel_name FROM Hotel where Hotel_id = 'KS001'"))['Hotel_name'];

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css" />
    <title>Home | hotel Taj</title>
    <style>
      body{
        background-color: #f0ffff	;
      }
    </style>
  </head>
  <body>
    <nav>
      <div class="nav__logo"><?php echo $HotelName; ?></div>
      <ul class="nav__links">
        <li class="link"><a href="#">Home</a></li>
        <li class="link"><a href="logout.php">Logout</a></li>
        <li class="link"><a href="contact.html">Feedback</a></li>
      </ul>
    </nav>
    <header class="section__container header__container">
      <div class="header__image__container">
        <div class="header__content">
          <h1>Enjoy Your Dream Vacation</h1>
          <p>Book Hotel rooms stay packages at lowest price.</p>
        </div>
        
      </div>
    </header>

    <!-- ... Existing HTML above this line ... -->

    <section class="section__container popular__container">
      <h2 class="section__header">Popular Room Types</h2>
      <div class="popular__grid">
          <div class="popular__card">
            <img src="https://shorturl.at/ouxzW" alt="popular room type" />
            <div class="popular__content">
              <div class="popular__card__header">
                <h4>Deluxe Rooms</h4>
                <h4>₹299</h4>
              </div>
              <p>Luxurious suite with a stunning view</p>
            </div>
          </div>
          <div class="popular__card">
              <img src="https://shorturl.at/cdfCG" alt="popular room type" height="318.4" width="178" />
              <div class="popular__content">
                  <div class="popular__card__header">
                      <h4>Singl Room</h4>
                      <h4>₹199</h4>
                  </div>
                  <p>Comfortable room with modern amenities</p>
              </div>
          </div>
        

        <div class="popular__card">
          <img src="https://shorturl.at/GRZ09" alt="popular room type" />
          <div class="popular__content">
            <div class="popular__card__header">
              <h4>Double Suite</h4>
              <h4>₹249</h4>
            </div>
            <p>Spacious suite perfect for families</p>
          </div>
        </div>
        <!-- Add more room types as needed -->
      </div>
      <form action="reserve.php"><br>
      <button type="submit" class="btn btn-primary">Book Now</button>
      </form>
    </section>
    

    <!-- ... Remaining HTML below this line ... -->

    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <h2>Location</h2>
          <p><?php echo $loc['address']; ?></p>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <p>About Us</p>
          <p>Contact Us</p>
        </div>
        <div class="footer__col">
          <p>FAQs</p>
          <p>Terms & Conditions</p>
          <p>Privacy Policy</p>
        </div>
        <div class="footer__col">
          <h4>Resources</h4>
          <p>Social Media</p>
          <p>Help Center</p>
          <p>Partnerships</p>
        </div>
    </div>
    </footer>
  </body>
</html>
