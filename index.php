<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Hotel Taj Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: url('https://images.unsplash.com/photo-1584132967334-10e028bd69f7?auto=format&fit=crop&q=80&w=2070&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100vh;
    }

    header {
      background-color: #333;
      color: #fff;
      text-align: center;
      padding: 20px;
    }

    h1 {
      margin: 0;
      font-size: 2rem;
    }

    .container {
      text-align: center;
      padding: 20px;
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      margin: auto; /* Center the container horizontally */
    }

    .button {
      background-color: #333;
      color: #fff;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
      border-radius: 5px;
    }

    .button:hover {
      background-color: #555;
    }
  </style>
</head>
<body>
  <header>
    <h1>Hotel Booking System</h1>
  </header>

  <div class="container">
    <h2>Welcome to our Hotel Booking System</h2>
    <p>Book your dream stay with us today!</p>
    <button class="button" id="bookNowButton">Book Now</button>
  </div>

  <script>
    document.getElementById('bookNowButton').addEventListener('click', function() {
      // You can add JavaScript code to handle the "Book Now" button click event here.
      // This could include redirecting to the room selection page or displaying a booking form.
      // For now, let's simply alert a message.
      window.location.href = 'login.php';
    });
  </script>
</body>
</html>