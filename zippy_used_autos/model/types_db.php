<?php
// model/types_db.php

function get_all_types() {
    global $db;
    $sql = "SELECT * FROM types ORDER BY type_name ASC";
    $statement = $db->prepare($sql);
    $statement->execute();
    $types = $statement->fetchAll();
    $statement->closeCursor();
    return $types;
}
?>