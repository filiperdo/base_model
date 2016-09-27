<?php

class Login extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/**
	 * Metodo index
	 */
	public function index()
	{
		$this->view->title = "Login";
		
		$this->view->render( "login/index" );
	}
	
	public function register()
	{
		Session::init();
		 
		$this->view->title = 'Cadastrar';
		 
		if( isset( $_SESSION[ PREFIX_SESSION . 'post_email'] ) ) {
			$this->view->email = Session::get('post_email');
			$this->view->login = Session::get('post_login');
		}
		else {
			$this->view->email = '';
			$this->view->login = '';
		}
		 
		$this->view->render('header.inc');
		$this->view->render('col-left');
		$this->view->render('login/register');
		$this->view->render('col-right');
		$this->view->render('footer.inc');
	}
	
	public function recover()
	{
		require_once 'models/user_model.php';
		$objUser = new User_Model();
		 
		/**
		 * Verifica se o email ja exite
		 * Configura os dados de cadastro em uma sessao para retornar a view de cadastro
		 */
		if( !$objUser->checkUserExisting( trim( $_POST['email'] ) ) )
		{
			$msg = base64_encode( 'EMAIL_NAO_ENCONTRADO' );
			header("location: " . URL . "login/?st=".$msg);
			exit();
		}
		 
		 
		$objUser->obterUserByEmail( $_POST['email'] );
		 
		//
		// Envia um senha recuperada para o user
		// =-=-=-=-=-=-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		require_once 'util/email.class.php';
		$objEmail = new Email();
		$objEmail->enviarSenhaRecuperada( $objUser );
		// =-=-=--=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
		 
		$msg = base64_encode( 'EMAIL_REDEFINIR_SENHA' );
		header("location: " . URL . "login?st=".$msg);
		exit();
	}
	
	function cadastro()
	{
		$this->view->title = 'Cadastrar';
		$this->view->render('login/form');
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