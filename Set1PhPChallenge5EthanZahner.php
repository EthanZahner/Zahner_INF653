<?php
// Define the initial price of the item
$price = 50;  // The original price before discount

# Define the discount amount
$discount = 10;  # Amount to be deducted from the original price

/* 
   Calculate the final price after applying the discount.
   The formula used is: final price = original price - discount
*/
$finalPrice = $price - $discount;

// Output the total price with proper formatting
echo "Total price: $" . $finalPrice . "\n"; // Concatenating string and variable
?>
