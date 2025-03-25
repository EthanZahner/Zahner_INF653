<?php
// admin/makes.php - Manage Makes

require('../model/database.php');
require('../model/makes_db.php');

// Handle deletion
$make_id = filter_input(INPUT_GET, 'delete_make_id', FILTER_VALIDATE_INT);
if ($make_id) {
    delete_make($make_id);
    header("Location: makes.php");
    exit();
}

// Handle addition (form submit via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $make_name = filter_input(INPUT_POST, 'make_name', FILTER_SANITIZE_STRING);
    if ($make_name) {
        add_make($make_name);
    }
    // After adding, redirect to avoid resubmission
    header("Location: makes.php");
    exit();
}

// Get current list of makes
$makes = get_all_makes();
include('view/manage_makes.php');
?>