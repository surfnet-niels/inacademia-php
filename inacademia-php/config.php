<?php
/*
 *  This page contains config value you will have to change to sue this with your own client
 * 
 */


// Domain name of your client, your client must be reachable from the browser you are using
$InAcademiaClient_domain = 'FQDN of your client';

// The clientID you used to register at InAcademia
$ClientID = 'The_ClientID_as_registered_with_InAcademia';

// The URL InAcademia should return the result of the validation to.
// This URL must be regstered at InAcademia
$RedirectURL = 'https://' . $InAcademiaClient_domain . '/return.php';

// Requested validation.
// Allowed values must be one of 'affiliated', 'faculty+staff', 'employee', 'student'
$RequestedValidation = 'affiliated';

// This is the page the return page points to handle the recieved validation after recieving it from InAcademia
$validateURL = 'https://' . $InAcademiaClient_domain . '/validate.php';

// Should we display debug stuff?
// This will also stop the processing of the validation when recieved form InAcademia.
$debug = false;
?>

