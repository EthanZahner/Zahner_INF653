<?php
// admin/index.php - Admin vehicle list and delete


require('../model/database.php');
require('../model/vehicles_db.php');
require('../model/makes_db.php');
require('../model/types_db.php');
require('../model/classes_db.php');

// Check if a delete action is requested
$vehicle_id = filter_input(INPUT_GET, 'delete_vehicle_id', FILTER_VALIDATE_INT);
if ($vehicle_id) {
    // Call a model function to delete the vehicle by ID
    delete_vehicle($vehicle_id);
    // after deletion, redirect backto avoid re-submission
    header("Location: index.php");
    exit();
}

// Get all vehicles (maybe sorted by price by default for admin as well)
$vehicle_list = get_all_vehicles('price');

// Load the admin view
include('view/admin_vehicle_list.php');
?>