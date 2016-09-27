<?php 

class Datalog extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Datalog";
		$this->view->listarDatalog = $this->model->listarDatalog();

		$this->view->render( "header" );
		$this->view->render( "datalog/index" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo editForm
	*/
	public function form( $id = NULL )
	{
		$this->view->title = "Cadastrar Datalog";
		$this->view->action = "create";
		$this->view->obj = $this->model;

		if( $id ) 
		{
			$this->view->title = "Editar Datalog";
			$this->view->action = "edit/".$id;
			$this->view->obj = $this->model->obterDatalog( $id );

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}

		$this->view->render( "header" );
		$this->view->render( "datalog/form" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo create
	*/
	public function create()
	{
		$data = array(
			'date' => $_POST["date"], 
			'id_user' => $_POST["id_user"], 
			'id_post' => $_POST["id_post"], 
			'id_product' => $_POST["id_product"], 
			'ip' => $_POST["ip"], 
		);

		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "datalog?st=".$msg);
	}

	/** 
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			'date' => $_POST["date"], 
			'id_user' => $_POST["id_user"], 
			'id_post' => $_POST["id_post"], 
			'id_product' => $_POST["id_product"], 
			'ip' => $_POST["ip"], 
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "datalog?st=".$msg);
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "datalog?st=".$msg);
	}
}
