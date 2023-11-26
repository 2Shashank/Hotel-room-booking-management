<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $checkIn = $_POST["check_in"];
    $checkOut = $_POST["check_out"];
    $roomType = $_POST["room_type"];
    $level = $_POST["room_level"];
    $paymentType = $_POST["payment_type"];

    $result = makeReservation($checkIn, $checkOut, $roomType, $level, $paymentType);

    if (isset($result["Message"])) {
        $transactionId = $result["Transaction_Id"];
        echo "<div class='alert alert-success'>Reservation successful! Transaction ID: $transactionId</div>";
    } else {
        $errorMessage = $result["Error"];
        echo "<div class='alert alert-danger'>$errorMessage</div>";
    }
}
function makeReservation($checkIn, $checkOut, $roomType, $level, $paymentType)
{
    global $conn;

    $procedureCall = "CALL MakeReservation(?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $procedureCall);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $checkIn, $checkOut, $roomType, $level, $paymentType);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $message, $transactionId);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        return ["Message" => $message, "Transaction_Id" => $transactionId];
    } else {
        return ["Error" => "Failed to prepare statement"];
    }

}
$HotelName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Name as Hotel_name FROM Hotel where Hotel_id = 'KS001'"))['Hotel_name'];

$result = mysqli_query($conn, "SELECT address from Hotel");
$loc = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include your custom stylesheet after Bootstrap -->
    <link rel="stylesheet" href="styles.css">
    <style>
      body{
        background-color: #f0ffff;
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><?php echo $HotelName; ?></a>
            <!-- Add your navigation links or other navigation components -->
        </div>
    </nav>
    <header class="section__container header__container">
        <div class="header__image__container">
            <div class="header__content">
                <h1>Reservation Page</h1>
                <p>Customize this page based on your reservation form requirements.</p>
            </div>
            <!-- Your reservation form goes here -->
            <form action="reserve.php" method="post" class="mx-auto text-center">
                <div class="mb-3">
                    <label for="check-in" class="form-label">Check In</label>
                    <input type="date" class="form-control form-control-lg mx-auto" name="check_in" id="check-in" placeholder="dd/mm/yyyy">
                </div>

                <div class="mb-3">
                    <label for="check-out" class="form-label">Check Out</label>
                    <input type="date" class="form-control form-control-lg mx-auto" name="check_out" id="check-out" placeholder="dd/mm/yyyy">
                </div>

                <div class="mb-3">
                    <label for="room-type" class="form-label">Room Type</label>
                    <select class="form-select form-select-lg mx-auto" id="room-type" name="room_type">
                        <option value="select">Select Type</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="deluxe">Deluxe</option>
                    </select>
                </div>
                <div class="mb-3">
                  <label for="room-level" class="form-label">Level</label>
                  <select class="form-select form-select-lg mx-auto" id="room-level" name="room_level">
                    <option value="">Select level</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                  </select>
                </div>


                <!-- Add more form fields as needed -->

                <button type="button" class="btn btn-primary" onclick="submitReservation()">Submit Reservation</button>
                <div class="payment-section mt-4" id="paymentSection" style="display: none;">
                <h2>Payment Information</h2>
                <div class="mb-3">
                  <select class="form-select form-select-lg mx-auto" id="payment-type" name="payment_type">
                    <option value="select_payment">Select Payment option</option>
                    <option value="Credit">Credit card</option>
                    <option value="UPI">UPI</option>
                  </select>
                    
                </div>
                <!-- Add more payment fields as needed -->

                <button type="submit" class="btn btn-success" onclick="makePayment()">Make Payment</button>
            </div>
            </form>
            
        </div>
    </header>

    <!-- Additional content or sections as needed -->

    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
        <h2>Location</h2>
          <p><?php echo $loc['address']; ?></p>
        </div>
        <div class="footer__col">
          <h4>Company</h4>
          <p>About Us</p>
          <p>Our Team</p>
          <p>Contact Us</p>
        </div>
        <div class="footer__col">
          <h4>Legal</h4>
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

    <!-- Include Bootstrap JS (optional, if you need Bootstrap JavaScript features) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function submitReservation() {
            // Add logic to handle reservation form submission
            // document.getElementById('reservationForm').style.display = 'none';

            document.getElementById('paymentSection').style.display = 'block';
        }

        function makePayment() {

            alert('Payment successful!'); // You can replace this with your actual payment processing logic
        }
    </script>
</body>
</html>
