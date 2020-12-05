<?php

require_once __DIR__.'\..\autoload.php';

use Hotel\User;

$user = new User();
// --------- get list of users in db ------------------
// $list = $user->getList();
// print_r($list);


//  --------- Create new user  ----------------
// $status = $user->insert('Jim', 'jim@ex.com', 'pass');
// var_dump($status);

// $list = $user->getList();
// print_r($list);

// Verify a user through his password
// $verified = $user->verify('g@ex.com', 123);
// var_dump($verified);
$verified = $user->verify('jim@ex.com', 'pass');
var_dump($verified);
