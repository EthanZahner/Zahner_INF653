<?php
// model/makes_db.php

function get_all_makes() {
    global $db;
    $sql = "SELECT * FROM makes ORDER BY make_name ASC";
    $statement = $db->prepare($sql);
    $statement->execute();
    $makes = $statement->fetchAll();
    $statement->closeCursor();
    return $makes;
}
function add_make($name) {
    global $db;
    $stmt = $db->prepare("INSERT INTO makes (make_name) VALUES (:name)");
    $stmt->bindValue(':name', $name);
    $stmt->execute();
    $stmt->closeCursor();
}
function delete_make($make_id) {
    global $db;
    $stmt = $db->prepare("DELETE FROM makes WHERE make_id = :mid");
    $stmt->bindValue(':mid', $make_id, PDO::PARAM_INT);
    $stmt->execute();
    $stmt->closeCursor();
}

?>