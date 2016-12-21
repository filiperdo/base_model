<?php

class Category extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/**
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Categoria";
		$this->view->listarCategory = $this->model->listarCategory();

		$this->view->render( "header" );
		$this->view->render( "category/index" );
		$this->view->render( "footer" );
	}

	/**
	* Metodo editForm
	*/
	public function form( $id = NULL )
	{
		$this->view->title = "Cadastrar Categoria";
		$this->view->action = "create";
		$this->view->obj = $this->model;

		require_once 'models/typecategory_model.php';
		$objType = new Typecategory_Model();
		$this->view->listTypeCategory = $objType->listarTypecategory();

		if( $id )
		{
			$this->view->title = "Editar Categoria";
			$this->view->action = "edit/".$id;
			$this->view->obj = $this->model->obterCategory( $id );

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}

		$this->view->render( "header" );
		$this->view->render( "category/form" );
		$this->view->render( "footer" );
	}

	/**
	* Metodo create
	*/
	public function create()
	{
		$data = array(
			'name' => $_POST["name"],
			'id_typecategory' => $_POST["id_typecategory"],
		);

		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "category?st=".$msg);
	}

	/**
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			'name' => $_POST["name"],
			'id_typecategory' => $_POST["id_typecategory"],
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "category?st=".$msg);
	}

	/**
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "category?st=".$msg);
	}
}
