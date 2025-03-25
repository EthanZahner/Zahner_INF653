<?php
// model/vehicles_db.php
function get_all_vehicles($orderBy = 'price') {
    // Access the global $db connection
    global $db;
    //Determine the column to sort by (safety: whitelist acceptable values)
    $orderByColumn = ($orderBy === 'year') ? 'year' : 'price';
    $sql = "SELECT V.vehicle_id, V.year, V.model, V.price, 
                   M.make_name, T.type_name, C.class_name
            FROM vehicles V
            JOIN makes M ON V.make_id = M.make_id
            JOIN types T ON V.type_id = T.type_id
            JOIN classes C ON V.class_id = C.class_id
            ORDER BY V.$orderByColumn DESC";
    $statement = $db->prepare($sql);
    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();
    return $vehicles;
}

function get_vehicles_by_make($make_id, $orderBy = 'price') {
    global $db;
    $orderByColumn = ($orderBy === 'year') ? 'year' : 'price';
    $sql = "SELECT V.vehicle_id, V.year, V.model, V.price,
                   M.make_name, T.type_name, C.class_name
            FROM vehicles V
            JOIN makes M ON V.make_id = M.make_id
            JOIN types T ON V.type_id = T.type_id
            JOIN classes C ON V.class_id = C.class_id
            WHERE V.make_id = :make_id
            ORDER BY V.$orderByColumn DESC";
    $statement = $db->prepare($sql);
    $statement->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();
    return $vehicles;
}

function get_vehicles_by_type($type_id, $orderBy = 'price') {
    global $db;
    $orderByColumn = ($orderBy === 'year') ? 'year' : 'price';
    $sql = "SELECT V.vehicle_id, V.year, V.model, V.price,
                   M.make_name, T.type_name, C.class_name
            FROM vehicles V
            JOIN makes M ON V.make_id = M.make_id
            JOIN types T ON V.type_id = T.type_id
            JOIN classes C ON V.class_id = C.class_id
            WHERE V.type_id = :type_id
            ORDER BY V.$orderByColumn DESC";
    $statement = $db->prepare($sql);
    $statement->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();
    return $vehicles;
}

function get_vehicles_by_class($class_id, $orderBy = 'price') {
    global $db;
    $orderByColumn = ($orderBy === 'year') ? 'year' : 'price';
    $sql = "SELECT V.vehicle_id, V.year, V.model, V.price,
                   M.make_name, T.type_name, C.class_name
            FROM vehicles V
            JOIN makes M ON V.make_id = M.make_id
            JOIN types T ON V.type_id = T.type_id
            JOIN classes C ON V.class_id = C.class_id
            WHERE V.class_id = :class_id
            ORDER BY V.$orderByColumn DESC";
    $statement = $db->prepare($sql);
    $statement->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $statement->execute();
    $vehicles = $statement->fetchAll();
    $statement->closeCursor();
    return $vehicles;
}

function delete_vehicle($vehicle_id) {
    global $db;
    $sql = "DELETE FROM vehicles WHERE vehicle_id = :vid";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':vid', $vehicle_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}

function add_vehicle($year, $model, $price, $make_id, $type_id, $class_id) {
    global $db;
    $sql = "INSERT INTO vehicles (year, model, price, make_id, type_id, class_id)
            VALUES (:year, :model, :price, :make_id, :type_id, :class_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':year', $year, PDO::PARAM_INT);
    $stmt->bindValue(':model', $model);
    $stmt->bindValue(':price', $price);
    $stmt->bindValue(':make_id', $make_id, PDO::PARAM_INT);
    $stmt->bindValue(':type_id', $type_id, PDO::PARAM_INT);
    $stmt->bindValue(':class_id', $class_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}

?>
