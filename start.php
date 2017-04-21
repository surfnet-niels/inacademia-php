<?php

// Include config
include 'inacademia-php/config.php';
include 'inacademia-php/inacademia.php';

// Allow requestedvalidation to be passed in via the URL
if (isset($_GET["requestedvalidation"])) {
	$RequestedValidation = $_GET["requestedvalidation"];
}

// Start validation
validate($ClientID, $RequestedValidation, $RedirectURL);

?>

