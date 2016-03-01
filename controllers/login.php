<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();    
    }
    
    function index() 
    {    
        $this->view->title = 'Login';
        $this->view->render('login/login');
    }
    
    function run()
    {
        $this->model->run();
    }
    
    function logout()
    {
    	$this->model->logout();
    }
    

}