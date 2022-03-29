<?php
include_once 'user_manager.php';


// $user = array(
//     'mail' => 'molinerozadkiel@gmail.om',
//     // 'nick' => '',
//     'pass' => '123123123',
// );

$user = array(
    'mail' => 'user@manager.net',
    'nick' => 'user',
    'pass' => 'salibaba',
    'name' => 'oh my',
    'last' => 'goat',
);



try {
    $user_manager = new UserManager();
    $bar = $user_manager->create($user);
} catch (InvalidMail $e) {
    // $bar = $e->getCode();
    $bar = $e->getMessage();
}

echo json_encode(['test' => $bar]);
