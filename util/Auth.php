<?php
/**
 * 
 */
class Auth
{
    public static function handleLogin()
    {
        @session_start();
        
        if ( !$_SESSION['loggedIn'] )
        {
            session_destroy();
            header('location: ' . URL . 'login');
            exit;
        }
    }
    
}