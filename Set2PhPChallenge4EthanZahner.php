<?php
// Define student's marks
$marks = 85; // Change this value to test different cases

// Determine the grade based on conditions
if ($marks >= 90) {
    $grade = "A";
} elseif ($marks >= 80) {
    $grade = "B";
} elseif ($marks >= 70) {
    $grade = "C";
} elseif ($marks >= 60) {
    $grade = "D";
} else {
    $grade = "F";
}

// Display the results
echo "Input: $marks\n";
echo "Output: You got a $grade!\n";
?>
