<?php
/*

CRUD for users

*/
include_once 'dbh.inc.php';




class UserManager {
    
    public $defaults = array(
        'mail' => 'default_mail',
        'nick' => 'default_nick',
        'pass' => 'default_pass',
        'name' => 'default_name',
        'last' => 'default_last',
    );
   
   
    function create($user) {
        $user = $this->set_defaults($user);
        if( $this->is_invalid_mail ($user['mail'])){ return False; }
        if( $this->is_mail_taken   ($user['mail'])){ return False; }

        return $this->is_mail_taken($user['mail']);
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



    function set_defaults($data){
        foreach ( $this->defaults as $key => $value ) {
            if( !isset($data[$key] )){ $data[$key] = $value; }
        }
        return $data;
    }

    function is_invalid_mail($mail){ return !filter_var($mail, FILTER_VALIDATE_EMAIL); }
    function is_mail_taken($mail){
        $conn = get_db_connection();
	    $query = "SELECT * FROM users WHERE eml = '$mail';";
        $response = $conn->query($query)->fetchAll();

        return (count($response) > 0);
    }
}
