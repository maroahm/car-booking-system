<?php
session_start();
$loggedIn = isset($_SESSION['user']);

$carId = $_GET['car_id'] ?? null; 

include_once 'inc/storage.php';
$file = new JsonIO('data/cars.json');
$cars = $file->load(true);
$car = null;
if ($carId) {
    foreach ($cars as $c) {
        if ($c['id'] == $carId) {
            $car = $c;
            break;
        }
    }
}

if (!$car) {
    die("Car details not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
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
                    <img src="images/userIcon.png" alt="userIcon">
                </div>
                <div class="user-options">
                    <button onclick = "window.location.href = 'profile.php'">My Reservations</button>
                    <button onclick = "window.location.href = 'logout.php'">Logout</button>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <h1>Booking Successful!</h1>

    <?php if ($car): ?>
        <div class="booking-confirmation">
            <h2><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h2>
            <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['model']) ?>" style="max-width: 300px;">
            <p>Your booking for this car has been confirmed.</p>
            <p><a href="index.php">Back to Homepage</a></p>
        </div>
    <?php else: ?>
        <p>Error loading car details.</p>
    <?php endif; ?>
</body>
</html>