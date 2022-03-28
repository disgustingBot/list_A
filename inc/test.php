<?php
include_once 'user_manager.php';


$user = array(
    'mail' => 'molinerozadkiel@gmail.om',
    // 'nick' => '',
    'pass' => '123123123',
);



try {
    $user_manager = new UserManager();
    $bar = $user_manager->create($user);
} catch (InvalidMail $e) {
    // $bar = $e->getCode();
    $bar = $e->getMessage();
}

echo json_encode(['test' => $bar]);
