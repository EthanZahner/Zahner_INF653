<?php
// admin/add_vehicle.php

require('../model/database.php');
require('../model/vehicles_db.php');
require('../model/makes_db.php');
require('../model/types_db.php');
require('../model/classes_db.php');

//If form is submitted, handle the new vehicle data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
    $modelName = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_STRING);
    $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
    $make_id = filter_input(INPUT_POST, 'make_id', FILTER_VALIDATE_INT);
    $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
    $class_id = filter_input(INPUT_POST, 'class_id', FILTER_VALIDATE_INT);

    if ($year && $modelName && $price && $make_id && $type_id && $class_id) {
        // call model function to add vehicle
        add_vehicle($year, $modelName, $price, $make_id, $type_id, $class_id);
        header("Location: index.php");  // redirect back to admin list
        exit();
    } else {
        $error = "Invalid vehicle data. Please check inputs.";
    }
}

// Get dropdown data for form
$makes = get_all_makes();
$types = get_all_types();
$classes = get_all_classes();

include('view/add_vehicle_form.php');
?>