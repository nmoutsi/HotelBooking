<?php

// Register autoload function
spl_autoload_register(function ($class) {
	//$class = str_replace("\\", "/", $class);
	//var_dump(sprintf('\..\%s.php', $class));
    require_once 'Hotel\User.php';
});
