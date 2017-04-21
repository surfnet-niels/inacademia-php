<?php

// This page validates the info recieved from the form post and vaidates against the call we made. 
include 'inacademia-php/config.php';
include 'inacademia-php/inacademia.php';

if($debug){ 
	echo "<hr>POST:<br>";
	var_dump($_POST);
	echo "<hr>Session:<br>";
	var_dump($_SESSION);
	echo "<hr>Server:<br>";
	var_dump($_SERVER);

	echo "<hr>";
}

try {
	handle_validation_resonse();
} catch (Exception $e) {
    exit("Error: " . $e->getMessage());
}
?>

<html>
    <head>
        <title>InAcademia Validation Test Page</title>
		<style type="text/css">
		body {
			color: #575757;
			line-height: 1.8;
			font-family: "Open Sans", Helvetica, sans-serif;
			font-size: 14px;
		}
		h2 {
			font-size: 25px;
			margin-top: 10px;
			margin-bottom: 10px;
			color: #094e76;
		}
		pre {
			background: #f5f5f5;
			color: #666;
			font-family: monospace;
			font-size: 14px;
			margin: 20px 0;
			overflow: auto;
			padding: 20px;
			white-space: pre;
			white-space: pre-wrap;
			word-wrap: break-word;
		}
		.InAcademiaLogo {
			float: right;
		}
		</style>
		<script>
		function showDiv(divName) {
			document.getElementById(divName).style.display = "block";
		}
		</script>
    </head>
    <body>
		<div id="InAcademiaLogo">
			<img src="https://inacademia.org/wp-content/uploads/2016/10/InAcademia_logo_500px.jpg">
		</div>
		<div id="validationResult">
		<?php 
		echo "<h2> Validation as '" .$_SESSION['inacademia']['requestedvalidation']. "': ";
		if ($_SESSION['inacademia']['validated']) {
			echo "Success!";
			echo "</h2>";
		} else {
			echo "Failed!";
			echo "</h2>";
			echo "InAcademia was succesful in contacting your institution, however we could not validate as '" . $_SESSION['inacademia']['requestedvalidation'] . "'.";
			echo "<br>The reason for this may was: '". $_SESSION['inacademia']['error_description'] . "'";
		}
		?>
		</div>
    </body>
</html>


<?php 
	// destroy session after validation
	session_destroy(); 
?>
