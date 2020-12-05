<?php

// Register autoload function
spl_autoload_register(function ($class) {
	//$class = str_replace("\\", "/", $class);
	//var_dump(sprintf('\..\%s.php', $class));
    require_once __DIR__.'\..\app\Hotel\User.php';
});

use Hotel\User;

$user = new User();

//Check if there is a token request

// The following didn't work...
// $userToken = $_REQUEST['user_token'];

$userToken = $_COOKIE['user_token'];
if ($userToken) {
	// Verify user
	if ($user->verifyToken($userToken)) {
	// Set user in memory
		$userInfo = $user->getTokenPayload($userToken);
		// print_r($userInfo);die;
		User::setCurrentUserId($userInfo['user_id']);
		// var_dump(User::getCurrentUserId());die;
		
	}
	
	
}
