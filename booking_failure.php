<?php
session_start();
$loggedIn = isset($_SESSION['user']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Failed</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <p>iKarRental</p>
        <div class="login-buttons-container">
            <?php if (!$loggedIn): ?>
                <form method="GET" action="register.php" class="registration-buttons">
                    <button type="submit">registration</button>
                </form>
                <form action="login.php" method="GET" class="registration-buttons">
                    <button type="submit">login</button>
                </form>
            <?php else: ?>
                <div class="user-icon">
                    <img src="userIcon.png" alt="userIcon">
                </div>
                <div class="user-options">
                    <button onclick = "window.location.href = 'profile.php'">My Reservations</button>
                    <button onclick = "window.location.href = 'logout.php'">Logout</button>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <h1>Booking Failed</h1>

    <div class="booking-failure">
        <p>Sorry, the car is already booked for the selected period or an error occurred.</p>
        <a href="index.php">Back to Homepage</a>
    </div>
</body>
</html>