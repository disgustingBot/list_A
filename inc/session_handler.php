<?php

// Basado en el post:
// https://www.sitepoint.com/writing-custom-session-handlers/

// Leer sobre sessiones y seguridad
// https://www.php.net/manual/en/session.security.php

// Dicho esto, este codigo no anda... jejejeje
function open($path, $name) {
  $session_id = session_id();

    // $conn2 = new PDO("mysql:host=myhost;dbname=mydb", "myuser", "mypassword");

    $sql = "INSERT INTO session SET session_id =" . $conn2->quote($session_id) . ", session_data = '' ON DUPLICATE KEY UPDATE session_lastaccesstime = NOW()";
    $conn2->query($sql);

    if ($conn2 === FALSE) {
       error_log("Failed to write session $session_id:";
    }

    return TRUE;
}
// echo open('','');


function read($session_id) {
    // $conn2 = new PDO("mysql:host=myhost;dbname=mydb", "myuser", "mypassword");

    $sql = "SELECT session_data FROM session where session_id =" . $conn2->quote($session_id);
    $result = $conn2->query($sql);

    if ($result === FALSE) {
       error_log("Failed to write session $session_id:";
    }
    $data = $result->fetchColumn();
    $result->closeCursor();

    return $data;
}


function write($session_id, $data) {
    // $conn2 = new PDO("mysql:host=myhost;dbname=mydb", "myuser", "mypassword");

    $sql = "INSERT INTO session SET session_id =" . $conn2->quote($session_id) . ", session_data =" . $conn2->quote($data) . " ON DUPLICATE KEY UPDATE session_data =" . $conn2->quote($data);
    $conn2->query($sql)
}


function close() {
    $session_id = session_id();
    //perform some action here
}


function destroy($session_id) {
    // $conn2 = new PDO("mysql:host=myhost;dbname=mydb", "myuser", "mypassword");

    $sql = "DELETE FROM session WHERE session_id =" . $conn2->quote($session_id);
    $conn2->query($sql);

    setcookie(session_name(), "", time() - 3600);
}


function gc($lifetime) {
    // $conn2 = new PDO("mysql:host=myhost;dbname=mydb", "myuser", "mypassword");

    // $sql = "DELETE FROM session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL " . $lifetime . " SECOND)";
    $sql = "DELETE FROM session WHERE session_lastaccesstime < DATE_SUB(NOW(), INTERVAL $lifetime SECOND)";
    $conn2->query($sql);
}

session_set_save_handler("open", "close", "read", "write", "destroy", "gc");
// session_set_save_handler("open", "close", "read", "write", "destroy", "garbage");
