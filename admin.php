<?php
session_start();
if (!isset($_SESSION["admin"])) {
   header("Location: admin.php");
}
require "database.php";

// Query to get the number of users
// $userCountQuery = "SELECT COUNT(*) as user_count FROM users";
// $userCountResult = mysqli_query($conn, "SELECT COUNT(*) as user_count FROM users");
$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as user_count FROM users"))['user_count'];

$HotelName = mysqli_fetch_assoc(mysqli_query($conn, "SELECT Name as Hotel_name FROM Hotel where Hotel_id = 'KS001'"))['Hotel_name'];

$Room_type = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) as room_types from rooms GROUP BY Room_type "))["room_types"];
$sql = "SELECT R.Reservation_Id,R.Transaction_Id,R.check_in,R.check_out,R.Room_type,R.level, P.mode
        FROM Reservation R 
        JOIN Payment P ON R.Transaction_Id = P.Transaction_Id";
$result = mysqli_query($conn, $sql);

$earn = " SELECT Ro.Price
FROM Rooms Ro 
JOIN Reservation R ON R.Room_type = Ro.Room_type AND R.level = Ro.Level
JOIN Payment P ON R.Transaction_Id = P.Transaction_Id";

$res = mysqli_query($conn, $earn);
// Calculate total earning
$totalEarning = 0;

while ($row = mysqli_fetch_assoc($res)) {
    $totalEarning += $row['Price'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="admin_styles.css" />
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom"><i
                    class="fas fa-handshake me-2"></i><?php echo $HotelName ?></div>
            <div class="list-group list-group-flush my-3">
                <a href="#" class="list-group-item list-group-item-action bg-transparent second-text active"><i
                        class="fas fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="users.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user me-2"></i>Users</a>
                <a href="rooms.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold"><i
                        class="fas fa-user me-2"></i>Rooms</a>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold"><i
                        class="fas fa-power-off me-2"></i>Logout</a>
            </div>
        </div>
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard</h2>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="container-fluid px-4">
                <div class="row g-3 my-2">
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $userCount; ?></h3>
                                <p class="fs-5">Users</p>
                            </div>
                            <i class="fas fa-gift fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2"><?php echo $Room_type; ?></h3>
                                <p class="fs-5">Room types</p>
                            </div>
                            <i
                                class="fas fa-hand-holding-usd fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded">
                            <div>
                                <h3 class="fs-2">₹<?php echo number_format($totalEarning, 2); ?></h3>
                                <p class="fs-5">Earning</p>
                            </div>
                            <i class="fas fa-chart-line fs-1 primary-text border rounded-full secondary-bg p-3"></i>
                        </div>
                    </div>
                </div>
                <div class="row my-5">
                    <h3 class="fs-4 mb-3">Recent Reservations</h3>
                    <div class="col">
                        <table class="table bg-white rounded shadow-sm  table-hover">
                            <thead>
                                <tr>
                                    <th scope="col" width="50">#</th>
                                    <th scope="col">Reservation ID</th>
                                    <th scope="col">Transaction ID</th>
                                    <th scope="col">Check In</th>
                                    <th scope="col">Check Out</th>
                                    <th scope="col">Room Type</th>
                                    <th scope="col">Level</th>
                                    <th scope="col">Mode of payment</th>
                                    <!-- <th scope="col">Price</th> -->
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<th scope='row'>$counter</th>";
                                    echo "<td>{$row['Reservation_Id']}</td>";
                                    echo "<td>{$row['Transaction_Id']}</td>";
                                    echo "<td>{$row['check_in']}</td>";
                                    echo "<td>{$row['check_out']}</td>";
                                    echo "<td>{$row['Room_type']}</td>";
                                    echo "<td>{$row['level']}</td>";
                                    echo "<td>{$row['mode']}</td>";
                                    // echo "<td>{$row['Price']}</td>";
                                    echo "</tr>";
                                    $counter++;
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var el = document.getElementById("wrapper");
        var toggleButton = document.getElementById("menu-toggle");
        toggleButton.onclick = function () {
            el.classList.toggle("toggled");
        };
    </script>
</body>
</html>