<?php 

class Ano extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Ano";
		$this->view->listarAno = $this->model->listarAno();

		$this->view->render( "header" );
		$this->view->render( "ano/index" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo editForm
	*/
	public function editForm($id)
	{
		$this->view->ano = $this->model->obterAno( $id );

		if ( empty( $this->view->ano ) ) {
			die( "Valor invalido!" );
		}

		$this->view->title = "Editar Ano";
		$this->view->render( "header" );
		$this->view->render( "ano/editForm" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo create
	*/
	public function create()
	{
		$data = array(
			//'id_ano' => $_POST["id_ano"], 
			'descricao' => $_POST["descricao"], 
		);

		$this->model->create( $data );
		$msg = base64_encode( "OPERACAO_SUCESSO" );
		header("location: " . URL . "ano?st=".$msg);
	}

	/** 
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			"id_ano" 	=> $id,
			'id_ano' => $_POST["id_ano"], 
			'descricao' => $_POST["descricao"], 
		);

		$this->model->edit( $data );
		$msg = base64_encode( "OPERACAO_SUCESSO" );
		header("location: " . URL . "ano?st=".$msg);
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id );
		$msg = base64_encode( "OPERACAO_SUCESSO" );
		header("location: " . URL . "ano?st=".$msg);
	}
}
