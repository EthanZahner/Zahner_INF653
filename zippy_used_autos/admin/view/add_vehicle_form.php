<!-- admin/view/add_vehicle_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Vehicle - Zippy Admin</title>
</head>
<body>
    <h1>Add New Vehicle</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form action="add_vehicle.php" method="post">
        <label>Make:</label>
        <select name="make_id">
            <?php foreach ($makes as $make): ?>
            <option value="<?= $make['make_id'] ?>"><?= htmlspecialchars($make['make_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Type:</label>
        <select name="type_id">
            <?php foreach ($types as $type): ?>
            <option value="<?= $type['type_id'] ?>"><?= htmlspecialchars($type['type_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Class:</label>
        <select name="class_id">
            <?php foreach ($classes as $class): ?>
            <option value="<?= $class['class_id'] ?>"><?= htmlspecialchars($class['class_name']) ?></option>
            <?php endforeach; ?>
        </select><br><br>

        <label>Year:</label>
        <input type="number" name="year" required><br><br>

        <label>Model:</label>
        <input type="text" name="model" required><br><br>

        <label>Price:</label>
        <input type="number" step="0.01" name="price" required><br><br>

        <button type="submit">Add Vehicle</button>
        <button type="button" onclick="window.location='index.php';">Cancel</button>
    </form>
</body>
</html>
