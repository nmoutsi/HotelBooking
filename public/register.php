<?php

require __DIR__.'/../boot/boot.php';

use Hotel\User;

// Check for existing logged in user
 if (!empty(User::getCurrentUserId())) {
	 header('Location: /HotelProject/public/index.php');die;
 }

?>

// Here goes the rest html code
