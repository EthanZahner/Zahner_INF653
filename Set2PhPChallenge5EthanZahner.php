<?php
// Define the year to check
$year = 2024; // Change this value to test different years

// Check if the year is a leap year
if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
    $result = "$year is a leap year.";
} else {
    $result = "$year is not a leap year.";
}

// Display the results
echo "Input: $year\n";
echo "Output: $result\n";
?>
