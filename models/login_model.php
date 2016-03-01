<?php

class Login_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function run()
    {
    	$sql  = 'SELECT * ';
    	$sql .= 'FROM user ';
    	$sql .= 'WHERE login = :login ';
    	$sql .= 'AND password = :password ';
    	
        $sth = $this->db->prepare( $sql );
        $sth->execute(array(
            ':login' 	=> $_POST['login'],
            ':password' => $_POST['password'] // Hash::create('sha256', $_POST['password'], HASH_PASSWORD_KEY)
        ));
        
        $data = $sth->fetch();
        
        if ( $sth->rowCount() > 0 )
        {
            // login
            Session::init();
            Session::set( 'loggedIn', true );
            Session::set( 'user_name', $data['name']);
            Session::set( 'userid', $data['id_user'] );
            header('location: ../index');
        }
        else
        {
        	$msg = base64_encode( 'LOGIN_INCORRETO' );
            header('location: ../login?st=' . $msg );
        }
    }
    
    public function logout()
    {
    	Session::init();
    	Session::destroy();
    	header('location: ../login');
    }
    
}