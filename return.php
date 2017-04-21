<?php
include 'inacademia-php/config.php';
include 'inacademia-php/inacademia.php';

// This page recieves the response from InAcademia and puts that in a form
// This is needed as InAcademia only supprts implicit flow which 

if($debug){ 
	echo "<hr>POST:<br>";
	var_dump($_POST);
	echo "<hr>Session:<br>";
	var_dump($_SESSION);
	echo "<hr>Server:<br>";
	var_dump($_SERVER);

	echo "<hr>";
}
?>

<html>
    <head>
        <title>InAcademia Client Page</title>
        <script type="text/javascript">
			function getHash(theForm, theHash) {
				theForm.hash.value = theHash;
<?php if(!$debug) {echo "				theForm.submit();";}?>
				return true;
			}
        </script>
    </head>
    <body onload="javascript:getHash(document.hash_form, window.location.hash);">
		<form action="<?php echo $validateURL ?>" method="post" id="hash_form" name="hash_form">

<?php 	if(!$debug) {
		echo '<input type="hidden" id="hash" name="hash" width="500">';
} else {
		echo '<input type="text" id="hash" name="hash" width="500">';
		echo '<input type="submit">';	
		}
?>
		</form>
    </body>
</html>
