<?php 

class Product extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Product";
		$this->view->listarProduct = $this->model->listarProduct();

		$this->view->render( "header" );
		$this->view->render( "product/index" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo editForm
	*/
	public function form( $id = NULL )
	{
		$this->view->title = "Cadastrar Product";
		$this->view->action = "create";
		$this->view->obj = $this->model;

		if( $id ) 
		{
			$this->view->title = "Editar Product";
			$this->view->action = "edit/".$id;
			$this->view->obj = $this->model->obterProduct( $id );

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}

		$this->view->render( "header" );
		$this->view->render( "product/form" );
		$this->view->render( "footer" );
	}

	/** 
	* Metodo create
	*/
	public function create()
	{
		$data = array(
			'name' => $_POST["name"], 
			'description' => $_POST["description"], 
			'data' => $_POST["data"], 
			'id_user' => $_POST["id_user"], 
			'status' => $_POST["status"], 
			'path' => $_POST["path"], 
			'mainpicture' => $_POST["mainpicture"], 
			'slug' => $_POST["slug"], 
			'price' => $_POST["price"], 
			'amount' => $_POST["amount"], 
		);

		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "product?st=".$msg);
	}

	/** 
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			'name' => $_POST["name"], 
			'description' => $_POST["description"], 
			'data' => $_POST["data"], 
			'id_user' => $_POST["id_user"], 
			'status' => $_POST["status"], 
			'path' => $_POST["path"], 
			'mainpicture' => $_POST["mainpicture"], 
			'slug' => $_POST["slug"], 
			'price' => $_POST["price"], 
			'amount' => $_POST["amount"], 
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "product?st=".$msg);
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "product?st=".$msg);
	}
}
