<!-- admin/view/manage_makes.php -->
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Manage Makes - Zippy Admin</title></head>
<body>
    <h1>Manage Vehicle Makes</h1>
    <ul>
      <?php foreach ($makes as $make): ?>
        <li>
          <?= htmlspecialchars($make['make_name']) ?>
          <a href="makes.php?delete_make_id=<?= $make['make_id'] ?>"
             onclick="return confirm('Delete this make?');">Delete</a>
        </li>
      <?php endforeach; ?>
    </ul>
    <h2>Add New Make</h2>
    <form action="makes.php" method="post">
        <label for="make_name">Make Name:</label>
        <input type="text" name="make_name" id="make_name" required>
        <button type="submit">Add</button>
    </form>
    <p><a href="index.php">Back to Vehicle List</a></p>
</body>
</html>
