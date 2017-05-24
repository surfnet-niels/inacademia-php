<?php
// Set session(cookie) parameters
session_set_cookie_params ( 5*60, "/", $InAcademiaClient_domain, true, true);
session_start();

// Load the OIDC client library and PHP Seclib library
require $_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php';

// InAcademia OP location
$InAcademiaURL = 'https://op.srv.inacademia.org';

function validate($clientID, $requestedValidation, $redirectURL) {
    if (!in_array($requestedValidation, array('affiliated', 'faculty+staff', 'employee', 'student'), true)){
        throw new Exception('Selected affiliation is not supported for validation');
    }
	
	$_SESSION['inacademia']['validated'] = false;
	$_SESSION['inacademia']['requestedvalidation'] = $requestedValidation;
	$_SESSION['inacademia']['scopes'] = array("openid", "transient", $requestedValidation);

	$oidc = new OpenIDConnectClient('https://op.srv.inacademia.org',
									$clientID,
									'InAcademiaDoesNotNeedAClientSecret!');

	$ResponseType = array('id_token');
	$oidc->setResponseTypes($ResponseType);
	$oidc->setRedirectURL($redirectURL);

	// Set Scopes
	foreach ($_SESSION['inacademia']['scopes'] as &$scope) {
		$oidc->addScope($scope);
	}

	// This starts the validation request
	$oidc->authenticate();
}

function handle_validation_resonse() {
	// test if we had recieved the state and id_token and we have a oidc state from a started active session
	if( isset($_POST['hash']) and isset($_SESSION['openid_connect_state']) ) {
		// check if the state matches the oidc state we started with 
		$varArray = explode('&', substr($_POST['hash'], 1));
		foreach ($varArray as $val) {
			$splitVar = explode("=", $val);
			$resultsArr[$splitVar[0]] = $splitVar[1];
		}

		if (isset($resultsArr['state'])) {
			if ($resultsArr['state'] == $_SESSION['openid_connect_state']) {
				// state params match, so this is a session we requested
				$_SESSION['inacademia']['state_validated'] = true;
				
				foreach($resultsArr as $key => $value){
					
					switch ($key) {
					case "state":
						$_SESSION['inacademia']['state'] = $value;
						break;
					case "id_token":
						$_SESSION['inacademia']['id_token'] = $value;
						$_SESSION['inacademia']['validated'] = true;
						break;
					case "error":
						$_SESSION['inacademia']['error'] = str_replace('_', ' ', $value);;
						break;
					case "error_description":
						$_SESSION['inacademia']['error_description'] = str_replace('+', ' ', urldecode($value));
						break;
					}
				}
				
				return true;
				
			} else {
				throw new Exception('Session OIDC state did not match post OIDC state!');
				//return "Session OIDC state did not match post OIDC state!  ...  aborting!";
			}
		} else {
			throw new Exception('Application state missing!');
			//exit("Application state missing!  ...  aborting!"); 
		}	
	} else {
		throw new Exception('Unsolicited post!');
		//exit("Unsolicited post!  ...  aborting!");
	}
}	
?>
