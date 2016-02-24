<?php 

class Tipodesafio extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();		
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Tipodesafio";
		
		$this->view->listarTipodesafio = $this->model->listarTipodesafio();

		$this->view->render( "header" );
		$this->view->render( "tipodesafio/index" );
		$this->view->render( "footer" );
	}
	
	public function listarJson()
	{
		$json = '[';
		
		$total = count($this->model->listarTipodesafio());
		
		foreach( $this->model->listarTipodesafio() as $key => $valor )
		{
			$json .= json_encode($valor);
			if($key < count($total))
				$json .= ',';
		}
		$json .= ']';
		
		echo $json;
	}
	
	/** 
	* Metodo editForm
	*/
	public function form( $id = NULL ) // Colocar o $id opcional para editar e cadastrar
	{
		$this->view->title = "Cadastrar Tipodesafio";
		$this->view->action = 'create';
		$this->view->obj = $this->model;
		
		if( $id ) // Verificar se o id existe
		{
			$this->view->title = "Editar Tipodesafio";
			$this->view->action = 'edit/'.$id;
			$this->view->obj = $this->model->obterTipodesafio( $id );
			
			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}
		
		$this->view->render( "header" );
		$this->view->render( "tipodesafio/form" ); // Mudar o nome para form
		$this->view->render( "footer" );
	}

	/** 
	* Metodo create
	*/
	public function create()
	{
		$data = array(
			//'id_tipodesafio' 	=> $_POST["id_tipodesafio"], 
			'descricao' 		=> $_POST["descricao"], 
			'file' 				=> $_POST["file"], 
		);
		
		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );
		
		header("location: " . URL . "tipodesafio?st=".$msg);
	}

	/** 
	* Metodo edit
	*/
	public function edit( $id )
	{
		$data = array(
			//"id_tipodesafio" 	=> $id, // Remover este ID 
			'descricao' 		=> $_POST["descricao"], 
			'file' 				=> $_POST["file"], 
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );
			
		header("location: " . URL . "tipodesafio?st=".$msg);
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );
		
		header("location: " . URL . "tipodesafio?st=".$msg);
	}
}
