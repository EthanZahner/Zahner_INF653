<!-- view/vehicles_list.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zippy Used Autos</title>
</head>
<body>
    <h1>Zippy Used Autos - Inventory</h1>
    
    <!-- Filter and Sort Form -->
    <form action="index.php" method="get" style="margin-bottom: 1em;">
        <!-- Make Dropdown -->
        <label for="make_id">Make:</label>
        <select name="make_id" id="make_id">
            <option value="">-- All Makes --</option>
            <?php foreach ($makes as $make): ?>
                <option value="<?= $make['make_id'] ?>" 
                    <?= ($make_id ?? null) == $make['make_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($make['make_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Type Dropdown -->
        <label for="type_id">Type:</label>
        <select name="type_id" id="type_id">
            <option value="">-- All Types --</option>
            <?php foreach ($types as $type): ?>
                <option value="<?= $type['type_id'] ?>"
                    <?= ($type_id ?? null) == $type['type_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['type_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Class Dropdown -->
        <label for="class_id">Class:</label>
        <select name="class_id" id="class_id">
            <option value="">-- All Classes --</option>
            <?php foreach ($classes as $class): ?>
                <option value="<?= $class['class_id'] ?>"
                    <?= ($class_id ?? null) == $class['class_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($class['class_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- Sort Dropdown -->
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
            <option value="price" <?= ($current_sort == 'price') ? 'selected' : '' ?>>Price (High to Low)</option>
            <option value="year" <?= ($current_sort == 'year') ? 'selected' : '' ?>>Year (New to Old)</option>
        </select>

        <button type="submit">Apply</button>
    </form>

    <!-- Vehicle Listings -->
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Year</th><th>Make</th><th>Model</th><th>Class</th><th>Type</th><th>Price</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($vehicle_list)): ?>
            <?php foreach ($vehicle_list as $vehicle): ?>
            <tr>
                <td><?= $vehicle['year'] ?></td>
                <td><?= htmlspecialchars($vehicle['make_name']) ?></td>
                <td><?= htmlspecialchars($vehicle['model']) ?></td>
                <td><?= htmlspecialchars($vehicle['class_name']) ?></td>
                <td><?= htmlspecialchars($vehicle['type_name']) ?></td>
                <td>$<?= number_format($vehicle['price'], 2) ?></td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">No vehicles found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
