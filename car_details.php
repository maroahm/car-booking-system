<?php
include_once 'inc/storage.php';

session_start();

$loggedIn = isset($_SESSION['user']);

$carId = $_GET['id'] ?? null;

if (!$carId) {
    die("Car ID is missing.");
}

$file = new JsonIO('data/cars.json');
$cars = $file->load(true);
$car = null;

foreach ($cars as $c) {
    if ($c['id'] == $carId) {
        $car = $c;
        break;
    }
}

if (!$car) {
    die("Car not found.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental - Car Details</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
    <button class="homeButton" onclick = "window.location.href = 'index.php'">ikarRental</button>
        <div class="login-buttons-container">
            <?php if (!$loggedIn): ?>
                <div>
                    <button onclick = "window.location.href = 'login.php'">Login</button>
                    <button onclick = "window.location.href = 'register.php'">registeration</button>
                </div>
            <?php else: ?>
                <div class="user-icon">
                    <img src="images/userIcon.png" alt="userIcon">
                </div>
                <div class="user-options">
                    <button onclick = "window.location.href = 'profile.php'">My Reservations</button>
                    <button onclick = "window.location.href = 'logout.php'">Logout</button>
                    <?php if (isset($_SESSION['admin'])): ?>
                        <a href="admin/index.php">Admin Panel</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <div class="car-details">
        <h2><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h2>
        <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['model']) ?>" style="max-width: 500px;">
        <p>Year: <?= htmlspecialchars($car['year']) ?></p>
        <p>Transmission: <?= htmlspecialchars($car['transmission']) ?></p>
        <p>Fuel Type: <?= htmlspecialchars($car['fuel_type']) ?></p>
        <p>Passengers: <?= htmlspecialchars($car['passengers']) ?></p>
        <p>Daily Price: <?= htmlspecialchars($car['daily_price_huf']) ?> HUF</p>



        <?php if ($loggedIn): ?>
    <button onclick = "window.location.href = 'book_car.php?car_id=<?= htmlspecialchars($car['id']) ?>'">Book Now</button>
<?php else: ?>
    <p>Please <a href="login.php">login</a> to book this car.</p>
<?php endif; ?>

</body>
</html>