<?php
include_once 'user_manager.php';


$users = new UserManager();
$user = array(
    'mail' => 'molinerozadkiel@gmail.com',
    // 'nick' => '',
    'pass' => '',
);
$bar = $users->create($user);
echo json_encode(['test' => $bar]);
