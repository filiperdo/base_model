<?php 

class Event extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Event";
		$this->view->listarEvent = $this->model->listarEvent();

		$this->view->render( "header" );
		$this->view->render( "event/index" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo editForm
	*/
	public function form( $id = NULL )
	{
		$this->view->title = "Cadastrar Event";
		$this->view->action = "create";
		$this->view->obj = $this->model;
		$this->view->js[] = 'event.js';
		
		if( $id ) 
		{
			$this->view->title = "Editar Event";
			$this->view->action = "edit/".$id;
			$this->view->obj = $this->model->obterEvent( $id );

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}

		$this->view->render( "header" );
		$this->view->render( "event/form" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo create
	*/
	public function create()
	{
		Session::init();
		
		$data = array(
			'title' 		=> $_POST["title"], 
			'date' 			=> Data::formataDataBD($_POST["date"]), 
			'hour' 			=> $_POST["hour"], 
			'content' 		=> $_POST["content"], 
			'path' 			=> $_POST["path"], 
			'id_user' 		=> Session::get('userid') 
		);
		
		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "event?st=".$msg);
	}

	/** 
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			'title' 	=> $_POST["title"], 
			'date' 		=> Data::formataDataBD($_POST["date"]), 
			'hour' 		=> $_POST["hour"], 
			'content' 	=> $_POST["content"], 
			'path' 		=> $_POST["path"], 
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "event?st=".$msg);
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "event?st=".$msg);
	}
}
