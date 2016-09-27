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
    	$sql .= 'AND status = "ACTIVE" ';
    	
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
            Session::set( 'user_login', $data['login']);
            Session::set( 'userid', $data['id_user'] );
            
            header('location: ../index');
            
            // Atualiza a quantidade e o ultimo login
            $update  = 'update user as u ';
			$update .= 'set u.numlogin = u.numlogin + 1 ';
			$update .= 'where u.id_user = :id_user ';
			
			$sth_update = $this->db->prepare( $update );
            $sth_update->execute( array( 'id_user' => $data['id_user'] ) );
            
            
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
    	header('location: ../');
    }
    
}