<?php
// index.php - Public homepage controller


require('model/database.php');
require('model/vehicles_db.php');
require('model/makes_db.php');
require('model/types_db.php');
require('model/classes_db.php');

//Get URL parameters (if any) for sorting or filtering
$sort = filter_input(INPUT_GET, 'sort', FILTER_SANITIZE_STRING);
$make_id = filter_input(INPUT_GET, 'make_id', FILTER_VALIDATE_INT);
$type_id = filter_input(INPUT_GET, 'type_id', FILTER_VALIDATE_INT);
$class_id = filter_input(INPUT_GET, 'class_id', FILTER_VALIDATE_INT);

// Determine which data to fetch based on filters
if ($make_id) {
    $vehicle_list = get_vehicles_by_make($make_id, $sort);
} elseif ($type_id) {
    // call get_vehicles_by_type
    $vehicle_list = get_vehicles_by_type($type_id, $sort);
} elseif ($class_id) {
    // call get_vehicles_by_class
    $vehicle_list = get_vehicles_by_class($class_id, $sort);
} else {
    // No filter - get all vehicles
    $vehicle_list = get_all_vehicles($sort);
}

// also fetch all makes, types, classes for the dropdowns:
$makes = get_all_makes();
$types = get_all_types();
$classes = get_all_classes();

// determine current sort order (default to 'price' if not set or invalid)
$current_sort = ($sort === 'year') ? 'year' : 'price';

// Load the view for displaying the vehicles
include('view/vehicles_list.php');
?>