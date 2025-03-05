<?php
require_once('model/database.php');
require_once('model/assignment_db.php');
require_once('model/course_db.php');

$assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
$course_name = filter_input(INPUT_POST, 'course_name', FILTER_SANITIZE_SPECIAL_CHARS);

$course_id = filter_input(INPUT_POST, 'course_id', FILTER_VALIDATE_INT) ?: filter_input(INPUT_GET, 'course_id', FILTER_VALIDATE_INT);

$action = filter_input(INPUT_POST, 'action', FILTER_UNSAFE_RAW)
          ?: filter_input(INPUT_GET, 'action', FILTER_UNSAFE_RAW)
          ?: 'list_assignments';

switch ($action) {
    case "list_courses":
        $courses = get_courses();
        include('view/course_list.php');
        break;
    case "add_course":
        if (!empty($course_name)) {
            add_course($course_name);
            header("Location: .?action=list_courses");
            exit();
        } else {
            $error = "Invalid course name. Please check the field and try again.";
            include("view/error.php");
            exit();
        }
        break;
    case "add_assignment":
        if ($course_id && !empty($description)) {
            add_assignment($course_id, $description);
            header("Location: .?action=list_assignments&course_id=" . $course_id);
            exit();
        } else {
            $error = "Invalid assignment data. Check all fields and try again.";
            include("view/error.php");
            exit();
        }
        break;
    case "delete_course":
        if ($course_id) {
            try {
                delete_course($course_id);
                header("Location: .?action=list_courses");
                exit();
            } catch (PDOException $e) {
                $error = "You cannot delete a course if assignments exist in the course.";
                include('view/error.php');
                exit();
            }
        }
        break;
    case "delete_assignment":
        if ($assignment_id) {
            delete_assignment($assignment_id);
            header("Location: .?action=list_assignments&course_id=" . $course_id);
            exit();
        } else {
            $error = "Missing or incorrect assignment id.";
            include('view/error.php');
            exit();
        }
        break;
    case 'update_assignment':
        // Process update assignment requests.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $assignment_id = $_POST['assignment_id'];
            $description   = $_POST['description'];
            $course_id     = $_POST['course_id'];
            if (update_assignment($assignment_id, $description, $course_id)) {
                header("Location: .?action=list_assignments&course_id=" . $course_id);
                exit();

            } else {
                $error = "There was an error updating the assignment. Please try again.";
                $assignment = get_assignment_by_id($assignment_id);
                $courses    = get_courses();
                include('view/update_assignment.php');
            }
        } elseif (isset($_GET['id'])) {
            $assignment_id = $_GET['id'];
            $assignment    = get_assignment_by_id($assignment_id);
            $courses       = get_courses();
            include('view/update_assignment.php');
        } else {
            echo "Assignment ID not provided.";
        }
        break;
    case 'update_course':
        // Process update course requests.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $course_id   = $_POST['course_id'];
            $course_name = $_POST['course_name'];
            if (update_course($course_id, $course_name)) {
                header("Location: .?action=list_courses");
                exit();
            } else {
                $error = "There was an error updating the course. Please try again.";
                $course = get_course_by_id($course_id);
                include('view/update_course.php');
            }
        } elseif (isset($_GET['id'])) {
            $course_id = $_GET['id'];
            $course = get_course_by_id($course_id);
            if (!$course) {
                echo "Course not found.";
                exit();
            }
            include('view/update_course.php');
        } else {
            echo "Course ID not provided.";
        }
        break;
    default:
        $courses = get_courses();
        $assignments = get_assignments_by_course($course_id);
        include('view/assignment_list.php');
}
?>
