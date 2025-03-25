<?php
// model/classes_db.php

function get_all_classes() {
    global $db;
    $sql = "SELECT * FROM classes ORDER BY class_name ASC";
    $statement = $db->prepare($sql);
    $statement->execute();
    $classes = $statement->fetchAll();
    $statement->closeCursor();
    return $classes;
}
?>