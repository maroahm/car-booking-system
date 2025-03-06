<?php
include_once 'inc/storage.php';

session_start();

$loggedIn = isset($_SESSION['user']);
if (!$loggedIn) {
    header("Location: login.php"); 
    exit;
}

$carId = $_GET['car_id'] ?? null;
if (!$carId) {
    die("Car ID is missing.");
}

$carFile = new JsonIO('data/cars.json');
$car = $carFile->loadOne(['id' => intval($carId)]); 

if (!$car) {
    die("Car not found.");
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'] ?? '';
    $endDate = $_POST['end_date'] ?? '';

    if (empty($startDate)) {
        $errors['start_date'] = "Please select a start date.";
    }
    if (empty($endDate)) {
        $errors['end_date'] = "Please select an end date.";
    }

    if (empty($errors)) {
        if (strtotime($endDate) <= strtotime($startDate)) {
            $errors['end_date'] = "End date must be after the start date.";
        }

        if (empty($errors)) {
            $bookingFile = new JsonIO('data/bookings.json');
            $bookings = $bookingFile->load(true);
            $isBooked = false;
            foreach ($bookings as $booking) {
                if ($booking['car_id'] == $carId) {
                    if (
                        (strtotime($startDate) >= strtotime($booking['start_date']) && strtotime($startDate) <= strtotime($booking['end_date'])) ||
                        (strtotime($endDate) >= strtotime($booking['start_date']) && strtotime($endDate) <= strtotime($booking['end_date'])) ||
                        (strtotime($startDate) <= strtotime($booking['start_date']) && strtotime($endDate) >= strtotime($booking['end_date']))
                    ) {
                        $isBooked = true;
                        break;
                    }
                }
            }

            if ($isBooked) {
                header("Location: booking_failure.php");
                exit;
            } else {
                $newBooking = [
                    'user_email' => $_SESSION['user']['email'],
                    'car_id' => intval($carId),
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ];
                $bookingFile->save($newBooking);
                header("Location: booking_success.php?car_id=" . urlencode($carId));
                exit;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book <?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar">
        <p>iKarRental</p>
        <div class="login-buttons-container">
            <?php if (!$loggedIn): ?>
                <div>
                    <button onclick = "window.location.href = 'login.php'">Login</button>
                    <button onclick = "window.location.href = 'register.php'">registeration</button>
                    <button onclick = "window.location.href = 'index.php'">Homepage</button>
                </div>
            <?php else: ?>
                <div class="user-icon">
                    <img src="userIcon.png" alt="userIcon">
                </div>
                <div class="user-options">
                    <a href="profile.php">My Reservations</a>
                    <a href="logout.php">Logout</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <h1>Book <?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h1>

    <div class="car-details">
        <h2><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h2>
        <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['model']) ?>" style="max-width: 300px;">
        <p>Daily Price: <?= htmlspecialchars($car['daily_price_huf']) ?> HUF</p>
    </div>

    <form method="POST" action="" novalidate>
        <div>
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>">
            <?php if (isset($errors['start_date'])): ?>
                <div style="color: red;"><?= $errors['start_date'] ?></div>
            <?php endif; ?>
        </div>
        <div>
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>">
            <?php if (isset($errors['end_date'])): ?>
                <div style="color: red;"><?= $errors['end_date'] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">Confirm Booking</button>
    </form>
</body>
</html>