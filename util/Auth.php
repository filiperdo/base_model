<?php
/**
 * 
 */
class Auth
{
    public static function handleLogin()
    {
        @session_start();
        
        if ( !Session::get('loggedIn') )
        {
            session_destroy();
            header('location: ' . URL . 'login');
            exit;
        }
    }
    
}