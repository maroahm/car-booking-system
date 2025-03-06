<?php
include_once '../inc/storage.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$carId = $_GET['id'] ?? null;
if (!$carId) {
    die("Car ID is missing.");
}

$file = new JsonIO('../data/cars.json');
$cars = $file->load(true);
$carIndex = array_search($carId, array_column($cars, 'id'));

if ($carIndex === false) {
    die("Car not found.");
}

$carToDelete = $cars[$carIndex];

if (isset($carToDelete['image']) && file_exists('../' . $carToDelete['image'])) {
    unlink('../' . $carToDelete['image']);
}

unset($cars[$carIndex]);
$cars = array_values($cars);

$file->save($cars);

header('Location: index.php');
exit;
?>