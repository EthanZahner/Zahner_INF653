<?php
// Include required database and function files.
require_once 'model/database.php';
require_once 'model/assignment_db.php';
require_once 'model/course_db.php';

// Process the form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assignment_id = $_POST['assignment_id'];
    $description   = $_POST['description'];
    $course_id     = $_POST['course_id'];

    // Call the update function (defined in assignment_db.php).
    if (update_assignment($assignment_id, $description, $course_id)) {
        // Redirect to the assignments list after successful update.
        header("Location: assignment_list.php");
        exit;
    } else {
        $error = "There was an error updating the assignment.";
    }
}

// When accessed via GET, pre-fill the form with the current assignment details.
if (isset($_GET['id'])) {
    $assignment_id = $_GET['id'];
    // Fetch the assignment details.
    $assignment = get_assignment_by_id($assignment_id);
    // Fetch all courses for the dropdown.
    $courses = get_courses();
} else {
    die("Assignment ID not provided.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Assignment</title>
</head>
<body>
    <h1>Update Assignment</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="." method="post">
    <!-- Hidden input to specify the update action -->
    <input type="hidden" name="action" value="update_assignment">
    <!-- Hidden field to hold the assignment ID -->
    <input type="hidden" name="assignment_id" value="<?php echo htmlspecialchars($assignment['ID']); ?>">
    
    <!-- Text input for description -->
    <p>
        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo htmlspecialchars($assignment['Description']); ?>">
    </p>
    
    <!-- Dropdown list for courses -->
    <p>
        <label for="course_id">Course:</label>
        <select id="course_id" name="course_id">
            <?php foreach ($courses as $course): ?>
                <option value="<?php echo $course['courseID']; ?>" <?php if ($course['courseID'] == $assignment['courseID']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($course['courseName']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </p>
    
    <!-- Submit button -->
    <p>
        <button type="submit">Update Assignment</button>
    </p>
</form>

</body>
</html>
