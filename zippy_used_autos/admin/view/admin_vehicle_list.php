<!-- admin/view/admin_vehicle_list.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zippy Used Autos - Admin</title>
</head>
<body>
    <h1>Admin - Vehicle List</h1>
    <p><a href="add_vehicle.php">Add New Vehicle</a></p>
    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>Year</th><th>Make</th><th>Model</th><th>Class</th><th>Type</th><th>Price</th><th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($vehicle_list as $v): ?>
            <tr>
                <td><?= $v['year'] ?></td>
                <td><?= htmlspecialchars($v['make_name']) ?></td>
                <td><?= htmlspecialchars($v['model']) ?></td>
                <td><?= htmlspecialchars($v['class_name']) ?></td>
                <td><?= htmlspecialchars($v['type_name']) ?></td>
                <td>$<?= number_format($v['price'], 2) ?></td>
                <td>
                    <a href="index.php?delete_vehicle_id=<?= $v['vehicle_id'] ?>" 
                       onclick="return confirm('Are you sure you want to delete this vehicle?');">
                       Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <p>
      <a href="makes.php">Manage Makes</a> | 
      <a href="types.php">Manage Types</a> | 
      <a href="classes.php">Manage Classes</a>
    </p>
</body>
</html>
