<?php
// model/database.php
$dsn = 'mysql:host=localhost;dbname=zippyusedautos';
$username = 'root';
$password = '';  // default root has no password

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error = "Database connection failed: " . $e->getMessage();
    exit($error);
}
?>
