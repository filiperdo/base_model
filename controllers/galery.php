<?php

class Galery extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/**
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Galeria";
		$this->view->listarGalery = $this->model->listarGalery();

		$this->view->render( "header" );
		$this->view->render( "galery/index" );
		$this->view->render( "footer" );
	}

	/**
	* Metodo editForm
	*/
	public function form( $id = NULL )
	{
		Session::init();

		$this->view->title = "Cadastrar Galeria";
		$this->view->action = "create";
		$this->view->obj = $this->model;
		$this->view->method_upload = URL . 'galery/wideimage_ajax/';

		if( $id == NULL )
		{
			if( !Session::get('path_galery') )
			{
				Session::set( 'path_galery', 'galery_' . date('Ymd_his') );
			}
			Session::set('act_post', 'create');
			$this->view->path = Session::get('path_galery');
		}
		else
		{
			$this->view->title = "Editar Galeria";
			$this->view->action = "edit/".$id;
			$this->view->obj = $this->model->obterGalery( $id );

			$this->view->path = $this->view->obj->getPath();
			Session::set( 'path_edit_galery', $this->view->obj->getPath() );
			Session::set('act_post', 'edit');

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}
		}

		$this->view->render( "header" );
		$this->view->render( "galery/form" );
		$this->view->render( "footer" );
	}

	/**
	* Metodo create
	*/
	public function create()
	{
		Session::init();

		$data = array(
			'name' 			=> $_POST["name"],
			'slug' 			=> Data::formatSlug($_POST["name"]),
			'path' 			=> $_POST["path"],
			'mainpicture' 	=> str_replace('../', '', $_POST['mainpicture']),
			'date' 			=> Data::formataDataBD($_POST["date"]),
			'id_user' 		=> Session::get('userid'),
		);

		$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		// Destruir sessao do path do post
		Session::destroy('path_galery');

		header("location: " . URL . "galery?st=".$msg);
	}

	/**
	* Metodo edit
	*/
	public function edit( $id )
	{
		Session::init();

		$data = array(
			'name' 			=> $_POST["name"],
			'slug' 			=> Data::formatSlug($_POST["name"]),
			'path' 			=> $_POST["path"],
			'mainpicture' 	=> str_replace('../', '', $_POST['mainpicture']),
			'date' 			=> Data::formataDataBD($_POST["date"]),
			'id_user' 		=> Session::get('userid'),
		);

		$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		// Destruir sessao do path do post
		Session::destroy('path_galery');

		header("location: " . URL . "galery?st=".$msg);
	}

	/**
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "galery?st=".$msg);
	}

	public function delete_img()
	{
		Session::init();

		$img_name = base64_decode( $_POST['img_name'] );

		$path =  'public/img/galery/' . base64_decode($_POST['path']) . '/';

		if(is_dir($path))
		{
 			unlink($path.$img_name);
			unlink($path.'thumb/'.$img_name);

			echo 'Deletou: ' .$path.$img_name.'<br>';
			echo 'Deletou: ' .$path.'thumb/'.$img_name;
 		}
		else
		{
			echo 'Nao deletou '.$path . $img_name;
		}
	}

	/**
	 * Faz o upload das imagens recebidas de um form
	 */
	public function wideimage_ajax()
	{
		Session::init();

		require_once 'util/wideimage/WideImage.php';

		$name 	= $_FILES['files']['name'];
		$tmp_name = $_FILES['files']['tmp_name'];

		$allowedExts = array(".gif", ".jpeg", ".jpg", ".png"); // passar estes parametros para o config

		// Verifica a acao para pegar a variavel do path correta
		Session::get('act_post') == 'create' ? $var_path = Session::get('path_galery') : $var_path = Session::get('path_edit_galery');

		$dir = 'public/img/galery/'. $var_path .'/';

		for($i = 0; $i < count($tmp_name); $i++)
		{
			$ext = strtolower(substr($name[$i],-4));

			if(in_array($ext, $allowedExts))
			{
				$indice_img = ($i+1); // para nao criar img-0.jpg
				$new_name = 'img-' . $indice_img . '.jpg'; // converte sempre para jpg
				while ( file_exists($dir.$new_name) ) {
					$indice_img++;
					$new_name = 'img-' . $indice_img . '.jpg';
				}

				// cria a img default =========================================
				$image = WideImage::load( $tmp_name[$i] );
				$image = $image->resize(800, 600, 'inside');
				//$image = $image->crop('center', 'center', 170, 180);

				// verifica so o diretorio existe
				// caso contrario, criamos o diretorio com permissao para escrita
				if( !is_dir( $dir ) )
					mkdir( $dir, 0777, true);

				$image->saveToFile( $dir . $new_name, 70 );

				// cria a img thumb ==========================================
				$image_thumb = WideImage::load( $tmp_name[$i] );
				$image_thumb = $image_thumb->resize(290, 250, 'outside');
				$image_thumb = $image_thumb->crop('center', 'top', 290, 250);

				$dir_thumb = $dir.'thumb/';
				// verifica so o diretorio existe
				// caso contrario, criamos o diretorio com permissao para escrita
				if( !is_dir( $dir_thumb ) )
					mkdir( $dir_thumb, 0777, true);

				$image_thumb->saveToFile( $dir_thumb . $new_name );
			}
		}

		echo json_encode($new_name);
	}
}
