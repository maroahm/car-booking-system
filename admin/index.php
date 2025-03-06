<?php
include_once '../inc/storage.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$file = new JsonIO('../data/cars.json');
$cars = $file->load(true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-car-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .admin-car-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            text-align: center;
        }
        .admin-car-item img {
            max-width: 100%;
            height: auto;
        }
        .admin-car-actions button {
            margin: 5px;
            padding: 8px 12px;
            cursor: pointer;
        }
        .logout-button{
            position:fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            padding : 10px 20px;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
    <p>Welcome, Admin!</p>
    <div><a href="add_car.php">Add New Car</a></div>

    <h2>Car List</h2>
    <div class="admin-car-list">
    <?php if (is_array($cars)): ?>
        <?php foreach ($cars as $car): ?>
            <div class="admin-car-item">
                <img
                    src="<?= (strpos($car['image'], '://') === false ? '../' : '') . htmlspecialchars($car['image'] ?? '') ?>"
                    alt="<?= htmlspecialchars($car['model'] ?? '') ?>"
                    style="max-height: 150px;"
                >
                <h3>
                    <?= htmlspecialchars(($car['brand'] ?? '') . ' ' . ($car['model'] ?? '')) ?>
                </h3>
                <p>
                    Price:
                    <?= htmlspecialchars($car['daily_price_huf'] ?? '') ?>
                    HUF
                </p>
                <div class="admin-car-actions">
                    <button onclick="location.href='edit_car.php?id=<?= htmlspecialchars($car['id'] ?? '') ?>'">
                        Edit
                    </button>
                    <button onclick="location.href='delete_car.php?id=<?= htmlspecialchars($car['id'] ?? '') ?>'">
                        Delete
                    </button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php else: ?>
            <p>No cars available.</p>
        <?php endif; ?>
   
    </div>
    <button class="logout-button" onclick = "window.location.href = '../logout.php'">Logout</button>
</body>
</html>
