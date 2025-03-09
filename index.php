<?php
include_once 'inc/storage.php';

session_start();

if (!isset($_SESSION['seats'])) {
    $_SESSION['seats'] = 0;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['decrement']) && $_SESSION['seats'] > 0) {
        $_SESSION['seats']--;
    }

    if (isset($_POST['increment']) && $_SESSION['seats'] < 10) {
        $_SESSION['seats']++;
    }
}

$loggedIn = isset($_SESSION['user']);
$userName = $loggedIn ? $_SESSION['user']['fullname'] : '';

$file = new JsonIO('data/cars.json');
$cars = $file->load(true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['gearType'])) {
        $cars = array_filter($cars, function ($car) {
            return $car['transmission'] === $_POST['gearType'];
        });
    }

    if (!empty($_SESSION['seats'])) {
        $cars = array_filter($cars, function ($car) {
            return $car['passengers'] >= $_SESSION['seats'];
        });
    }

    if (!empty($_POST['minPrice']) && !empty($_POST['maxPrice'])) {
        $minPrice = intval($_POST['minPrice']);
        $maxPrice = intval($_POST['maxPrice']);
        $cars = array_filter($cars, function ($car) use ($minPrice, $maxPrice) {
            return $car['daily_price_huf'] >= $minPrice && $car['daily_price_huf'] <= $maxPrice;
        });
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iKarRental - Homepage</title>
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
    <div>
        <h1>Rent Cars Easily!</h1>
    </div>
  <form method="POST" action="" class="filter-cars">
    <div class="seats-div">
        <button type="submit" name="decrement">-</button>
        <div class="counter-container"><?= $_SESSION['seats'] ?></div>
        <button type="submit" name="increment">+</button>
        <p>seats</p>
    </div>
    <div>
        <p>from</p>
        <input type="date" name="fromDate" id="fromDate" class="from-date">
    </div>
    <div>
        <p>until</p>
        <input type="date" name="untilDate" id="untilDate" class="until-date">
    </div>
    <div>
        <select name="gearType" id="gearType" class="gear-type">
            <option value="">Any</option>
            <option value="Automatic">Automatic</option>
            <option value="Manual">Manual</option>
        </select>
        <input type="text" name="minPrice" placeholder="Min Price"> <p>-</p>
        <input type="text" name="maxPrice" placeholder="Max Price">
    </div>
    <button type="submit" class="filter-button">Filter</button>
</form>

    <div class="car-list">
        <?php if (is_array($cars)): ?>
            <?php foreach ($cars as $car): ?>
                <div class="car-item">
                    <h2><?= htmlspecialchars($car['brand'] . ' ' . $car['model']) ?></h2>
                    <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['model']) ?>">
                    <p>Price: <?= htmlspecialchars($car['daily_price_huf']) ?> HUF/day</p>
                    <a href="car_details.php?id=<?= htmlspecialchars($car['id']) ?>">View Details</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No cars available.</p>
        <?php endif; ?>
    </div>
</body>
</html>