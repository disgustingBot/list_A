<?php
/*

CRUD for users

*/
include_once 'dbh.inc.php';




class UserManager {
   
    function create($user) {
        if( $this->is_invalid_mail ($user['mail'])){ throw new InvalidMail("provided email doesn't look like an e-mail"); }
        if( $this->is_mail_taken   ($user['mail'])){ throw new TakenMail("it seems there already is an account with that email"); }
        if( strlen($user['pass']) < 6 )            { throw new PasswordError("you forgot to add password security"); }

        $user['hash'] = password_hash($user['pass'], PASSWORD_DEFAULT); // Hashing the password

        $conn = get_db_connection();
        $sql = "INSERT INTO users (uid,fst,lst,eml,pwd) VALUES ('$user[nick]','$user[name]','$user[last]','$user[mail]','$user[hash]');";
        // $qry=$conn->prepare($sql);
        // $qry->execute();

        return "'$user[hash]'";
    }
    function read(){
        return 1;
    }
    function update(){
        return 1;
    }
    function delete(){
        return 1;
    }




    function is_invalid_mail($mail){ return !filter_var($mail, FILTER_VALIDATE_EMAIL); }
    function is_mail_taken($mail){
        $conn = get_db_connection();
	    $query = "SELECT * FROM users WHERE eml = '$mail';";
        $response = $conn->query($query)->fetchAll();

        return (count($response) > 0);
    }
}






/**
 * Definir una clase de excepción personalizada
 */
class TakenMail extends Exception {
    protected $code = 400;                        // código de excepción definido por el usuario
}
class InvalidMail extends Exception {
    protected $code = 401;                        // código de excepción definido por el usuario
}
class PasswordError extends Exception {
    protected $code = 402;                        // código de excepción definido por el usuario
}