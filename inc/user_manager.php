<?php
/*

CRUD for users

*/
include_once 'dbh.inc.php';




class UserManager {
    
    public $defaults = array(
        'mail' => 'default_mail',
        'nick' => 'default_nick',
        'name' => 'default_name',
        'last' => 'default_last',
    );
   
    function create($user) {
        $this->validate_data($user);
        $user = $this->set_defaults($user);


        
        // try {
        $db = get_db_connection();
        $sql = "INSERT INTO users (uid,fst,lst,eml,pwd) VALUES ('$user[nick]','$user[name]','$user[last]','$user[mail]','$user[hash]');";
        // $qry = $db->prepare($sql);
        // $qry->execute();
            
        return $sql;
        // } catch(PDOException $error) {throw new CreationError("There was a problem creating new user, please try again later or contact us if the problem persists");}

        // $this->insert($user);
        // return True;
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


    function insert($user){
        try {
            $con = get_db_connection();
            $sql = "INSERT INTO users (uid,fst,lst,eml,pwd) VALUES ('$user[nick]','$user[name]','$user[last]','$user[mail]','$user[hash]');";
            $qry = $con->prepare($sql);
            $qry->execute();
            
            return True;
        } catch(PDOException $error) {throw new CreationError("There was a problem creating new user, please try again later or contact us if the problem persists");}
    }
    function set_defaults($data){
        foreach ( $this->defaults as $key => $value ) {
            if( !isset($data[$key] )){ $data[$key] = $value; }
        }
        $data['hash'] = password_hash($data['pass'], PASSWORD_DEFAULT); // Hashing the password
        return $data;
    }

    function validate_data($user){
        if( $this->is_invalid_mail ($user['mail'])){ throw new InvalidMail("provided email doesn't look like an e-mail"); }
        if( $this->is_mail_taken   ($user['mail'])){ throw new TakenMail("it seems there already is an account with that email"); }
        if( strlen($user['pass']) < 6 )            { throw new PasswordError("you forgot to add password security"); }
    }
    function is_invalid_mail($mail){ return !filter_var($mail, FILTER_VALIDATE_EMAIL); }
    function is_mail_taken($mail){
        $db = get_db_connection();
	    $query = "SELECT * FROM users WHERE eml = '$mail';";
        $response = $db->query($query)->fetchAll();

        return (count($response) > 0);
    }
}






/**
 * Definir una clase de excepción personalizada
 */
class TakenMail extends Exception {
    // protected $code = 400;                        // código de excepción definido por el usuario
}
class InvalidMail extends Exception {
    // protected $code = 401;                        // código de excepción definido por el usuario
}
class PasswordError extends Exception {
    // protected $code = 402;                        // código de excepción definido por el usuario
}
class CreationError extends Exception {
    // protected $code = 403;                        // código de excepción definido por el usuario
}