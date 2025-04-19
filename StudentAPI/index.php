<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		SELECT 
		c.customerID, 
		c.emailAddress, 
		c.firstName, 
		c.lastName, 
		a.line1, 
		a.city, 
		a.state, 
		a.zipCode, 
		a.phone
	FROM customers c
	INNER JOIN addresses a ON c.customerID = a.customerID
	GROUP BY 
		c.customerID, 
		c.emailAddress, 
		c.firstName, 
		c.lastName, 
		a.line1, 
		a.city, 
		a.state, 
		a.zipCode, 
		a.phone;

		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/dashboard/');
	exit;
?>
Something is wrong with the XAMPP installation :-(
