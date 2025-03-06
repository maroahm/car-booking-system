<?php
include_once '../inc/storage.php';

session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = ['brand', 'model', 'year', 'transmission', 'fuel_type', 'passengers', 'daily_price_huf'];
    foreach ($fields as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = ucfirst($field) . ' is required.';
        }
    }

    if (empty($_FILES['image']['name'])) {
        $errors['image'] = 'Image is required.';
    }

    if (empty($errors)) {
        $uploadDir = '../uploads/';
        $uploadedFile = $_FILES['image']['tmp_name'];
        $filename = basename($_FILES['image']['name']);
        $newFilePath = $uploadDir . $filename;

        if (move_uploaded_file($uploadedFile, $newFilePath)) {
            $imageFilename = 'uploads/' . $filename;
            $newCar = array_merge($_POST, ['image' => $imageFilename]);

            $file = new JsonIO('../data/cars.json');
            $cars = $file->load(true);

            $maxId = 0;
            if (is_array($cars)) {
                foreach ($cars as $c) {
                    if (isset($c['id']) && (int)$c['id'] > $maxId) {
                        $maxId = (int)$c['id'];
                    }
                }
            } else {
                $cars = []; 
            }
            $newId = $maxId + 1;

            $newCar['id'] = $newId;

            $cars[] = $newCar;

            $file->save($cars);

            header('Location: index.php');
            exit;
        } else {
            $errors['image'] = 'Failed to upload image.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Add New Car</h1>
    <form method="POST" action="" enctype="multipart/form-data">
        <?php foreach (['brand', 'model', 'year', 'transmission', 'fuel_type', 'passengers', 'daily_price_huf'] as $field): ?>
            <div>
                <label for="<?= $field ?>"><?= ucfirst($field) ?>:</label>
                <input type="text" name="<?= $field ?>" id="<?= $field ?>"
                       value="<?= htmlspecialchars($_POST[$field] ?? '') ?>">
                <?php if (isset($errors[$field])): ?>
                    <div style="color: red;"><?= $errors[$field] ?></div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
        <div>
            <label for="image">Car Image:</label>
            <input type="file" name="image" id="image">
            <?php if (isset($errors['image'])): ?>
                <div style="color: red;"><?= $errors['image'] ?></div>
            <?php endif; ?>
        </div>
        <button type="submit">Add Car</button>
    </form>
    <a href="index.php">Back to Admin Panel</a>
</body>
</html>