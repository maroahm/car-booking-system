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

$carToEdit = null;
$carIndex = false; 
foreach ($cars as $index => $c) {
    if ($c['id'] == $carId) {
        $carToEdit = $c;
        $carIndex = $index; 
        break;
    }
}

if (!$carToEdit) {
    die("Car not found.");
}


$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['brand', 'model', 'year', 'transmission', 'fuel_type', 'passengers', 'daily_price_huf'];
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = ucfirst($field) . ' is required.';
        }
    }

    $imageFilename = $carToEdit['image']; 
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = '../uploads/';
        $uploadedFile = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $newFilePath = $uploadDir . $filename;

        if (move_uploaded_file($uploadedFile, $newFilePath)) {
            $imageFilename = 'uploads/' . $filename;
            if (isset($carToEdit['image']) && file_exists('../' . $carToEdit['image']) && '../' . $carToEdit['image'] != $newFilePath) {
                unlink('../' . $carToEdit['image']);
            }
        } else {
            $errors['image'] = 'Failed to upload image.';
        }
    }

    if (empty($errors)) {
        $cars[$carIndex] = array_merge($_POST, ['id' => intval($carId), 'image' => $imageFilename]);
        $file->save($cars);
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Edit Car</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($carToEdit['id']) ?>">
        <?php foreach (['brand', 'model', 'year', 'transmission', 'fuel_type', 'passengers', 'daily_price_huf'] as $field): ?>
            <div>
                <label for="<?= $field ?>"><?= ucfirst($field) ?>:</label>
                <input type="text" name="<?= $field ?>" id="<?= $field ?>" value="<?= htmlspecialchars($carToEdit[$field] ?? '') ?>">
                <?php if (isset($errors[$field])): ?>
                    <div style="color: red;"><?= $errors[$field] ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div>
            <label for="image">Car Image:</label>
            <input type="file" name="image" id="image">
            <img src="../<?= htmlspecialchars($carToEdit['image']) ?>" alt="Current Image" style="max-height: 100px;">
            <p>Current Image</p>
            <?php if (isset($errors['image'])): ?>
                <div style="color: red;"><?= $errors['image'] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">Save Changes</button>
    </form>
    <a href="index.php">Back to Admin Panel</a>
</body>
</html>