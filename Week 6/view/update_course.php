<?php
require_once 'model/database.php';
require_once 'model/course_db.php';

// Process the form submission.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id   = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    // Attempt to update the course.
    if (update_course($course_id, $course_name)) {
        // Redirect to the course list page upon success.
        header("Location: course_list.php");
        exit;
    } else {
        $error = "There was an error updating the course.";
        // Set the course array to repopulate the form.
        $course = array('courseID' => $course_id, 'courseName' => $course_name);
    }
} else {
    // When accessed via GET, pre-fill the form with the current course details.
    if (isset($_GET['id'])) {
        $course_id = $_GET['id'];
        $course = get_course_by_id($course_id);
        if (!$course) {
            die("Course not found.");
        }
    } else {
        die("Course ID not provided.");
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Update Course</title>
</head>
<body>
    <h1>Update Course</h1>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <form action="." method="post">
    <!-- Hidden input to specify the update action -->
    <input type="hidden" name="action" value="update_course">
    <!-- Hidden field for Course ID -->
    <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['courseID']); ?>">
    
    <!-- Text input for Course Name -->
    <p>
        <label for="course_name">Course Name:</label>
        <input type="text" id="course_name" name="course_name" value="<?php echo htmlspecialchars($course['courseName']); ?>">
    </p>
    
    <!-- Submit button -->
    <p>
        <button type="submit">Update Course</button>
    </p>
</form>

</body>
</html>
