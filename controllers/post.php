<?php

class Post extends Controller {

	public function __construct() {
		parent::__construct();
		//Auth::handleLogin();
	}

	/**
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Post";
		$this->view->listarPost = $this->model->listarPost();

		$this->view->render( "header" );
		$this->view->render( "post/index" );
		$this->view->render( "footer" );
	}

	/**
	* Metodo editForm
	*/
	public function form( $id_post = NULL )
	{
		Session::init();

		$this->view->title = "Cadastrar Post";
		$this->view->action = "create";
		$this->view->js[] = 'clipboard.min.js';
		$this->view->method_upload = URL . 'post/wideimage_ajax/';

		$this->view->obj = $this->model;
		$this->view->array_category = array();

		require_once 'models/category_model.php';
		$objCategoria = new Category_Model();
		$this->view->listCategory = $objCategoria->listarCategoryByType(1);

		$this->view->path = '';

		if( $id_post == NULL )
		{
			if( !Session::get('path_post') )
			{
				Session::set( 'path_post', 'img_post_' . date('Ymd_his') );
			}
			Session::set('act_post', 'create');
			$this->view->path = Session::get('path_post');
		}
		else
		{
			$this->view->title = "Editar Post: " . $id_post;
			$this->view->action = "edit/".$id_post;
			$this->view->obj = $this->model->obterPost( $id_post );

			$this->view->path = $this->model->getPath();

			Session::set('act_post', 'edit');
			Session::set('path_edit_post', $this->model->getPath());

			if ( empty( $this->view->obj ) ) {
				die( "Valor invalido!" );
			}

			// Monta o array com as categorias vinculadas ao post
			foreach ( $objCategoria->listCategoryByPost( $id_post ) as $category )
			{
				$this->view->array_category[] = $category->getId_category();
			}
		}

		$this->view->render( "header" );
		$this->view->render( "post/form" );
		$this->view->render( "footer" );

	}

	/**
	* Metodo create
	*/
	public function create()
	{
		Session::init();

		$this->model->db->beginTransaction();

		/**
		 * Cadastra o post
		 * @var unknown
		 */
		$data = array(
			'title' 		=> $_POST["title"],
			'slug'			=> Data::formatSlug($_POST["title"]),
			'content' 		=> $_POST["content"],
			'status' 		=> $_POST["status"],
			'path'			=> $_POST['path'],
			'mainpicture'	=> str_replace('../', '', $_POST['mainpicture']),
			'id_user'		=> Session::get('userid'),
			//'author'		=> $_POST['author'],
			//'source'		=> $_POST['source']
			'tags'			=> $_POST['tags']
		);

		if( !$id_post = $this->model->create( $data ) )
		{
			$this->model->db->rollBack();
			$msg = base64_encode( "OPERACAO_ERRO" );
			header("location: " . URL . "post?st=".$msg);
		}

		/**
		 * Cadastra as categorias do post
		 */
		if( isset($_POST['categoria']) )
		{
			foreach( $_POST['categoria'] as $id_categoria )
			{
				$data_category = array(
					'id_post'		=> $id_post,
					'id_category'	=> $id_categoria
				);

				if( !$this->model->db->insert( "post_category", $data_category, false ) )
				{
					$this->model->db->rollBack();
					$msg = base64_encode( "OPERACAO_ERRO" );
					header("location: " . URL . "post?st=".$msg);
				}
			}
		}

		// Destruir sessao do path do post
		Session::destroy('path_post');

		/**
		 * Realiza o commit e retorna a view
		 */
		$this->model->db->commit();
		$msg = base64_encode( "OPERACAO_SUCESSO" );
		header("location: " . URL . "post?st=".$msg);
	}

	/**
	* Metodo edit
	*/
	public function edit( $id )
	{
		$this->model->db->beginTransaction();

		/**
		 * Edita os dados do post
		 * @var unknown
		 */
		$data = array(
			'title' 		=> $_POST["title"],
			'slug'			=> Data::formatSlug($_POST["title"]),
			'content' 		=> $_POST["content"],
			'status' 		=> $_POST["status"],
			'mainpicture'	=> str_replace('../', '', $_POST['mainpicture']),
			//'author'		=> $_POST['author'],
			//'source'		=> $_POST['source']
			'tags'			=> $_POST['tags']
		);

		if( !$this->model->edit( $data, $id ) )
		{
			$this->model->db->rollBack();
			$msg = base64_encode( "OPERACAO_ERRO" );
			header("location: " . URL . "post?st=".$msg."&erro=1");
		}

		/**
		 * Cadastra as categorias do post
		 */
		// Deleta todas as categorias vinculadas ao post
		$this->model->db->deleteComposityKey( 'post_category', "id_post = {$id}" );

		if( isset($_POST['categoria']) )
		{
			foreach( $_POST['categoria'] as $id_categoria )
			{
				$data_category = array(
					'id_post'		=> $id,
					'id_category'	=> $id_categoria
				);

				if( !$this->model->db->insert( "post_category", $data_category, false ) )
				{
					$this->model->db->rollBack();
					$msg = base64_encode( "OPERACAO_ERRO" );
					header( "location: " . URL . "post?st=".$msg."&erro=3" );
				}
			}
		}

		// Destruir sessao do path do post
		Session::destroy('path_post');

		/**
		 * Realiza o commit e retorna a view
		 */
		$this->model->db->commit();

		$msg = base64_encode( "OPERACAO_SUCESSO" );
		header("location: " . URL . "post?st=".$msg);
	}

	/**
	* Metodo delete
	*/
	public function delete( $id )
	{
		// deletar primeiro os ids da tabela post_categor

		// estudar o que fazer com as imagens
		// talvez deixar a opcao para selecionar opcionalmente para deletar o post e as imagens

		$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );

		header("location: " . URL . "post?st=".$msg);
	}

	public function delete_img()
	{
		$img_name = base64_decode( $_POST['img_name'] );

		$path =  'public/img/post/' . base64_decode($_POST['path']) . '/';

		if(is_dir($path))
		{
 			unlink($path.$img_name);
			unlink($path.'thumb/'.$img_name);
			unlink($path.'media/'.$img_name);

			echo 'Deletou: ' .$path.$img_name;
			echo 'Deletou: ' .$path.'thumb/'.$img_name;
			echo 'Deletou: ' .$path.'media/'.$img_name;
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

		date_default_timezone_set("Brazil/East");

		$name 	= $_FILES['files']['name'];
		$tmp_name = $_FILES['files']['tmp_name'];

		$allowedExts = array(".gif", ".jpeg", ".jpg", ".png"); // passar isso para o config

		// Verifica a acao para pegar a variavel do path correta
		Session::get('act_post') == 'create' ? $var_path = Session::get('path_post') : $var_path = Session::get('path_edit_post');

		$dir = 'public/img/post/'. $var_path .'/';

		for($i = 0; $i < count($tmp_name); $i++)
		{
			$ext = strtolower(substr($name[$i],-4));

			if(in_array($ext, $allowedExts))
			{
				$indice_img = $i;
				$new_name = 'img-' . $indice_img . $ext;
				while ( file_exists($dir.$new_name) ) {
					$indice_img++;
					$new_name = 'img-' . $indice_img . $ext;
				}

				// cria a img default =========================================
				$image = WideImage::load( $tmp_name[$i] );

				$image = $image->resize(800, 600, 'inside');
				//$image = $image->crop('center', 'center', 170, 180);

				// verifica so o diretorio existe
				// caso contrario, criamos o diretorio com permissao para escrita
				if( !is_dir( $dir ) )
					mkdir( $dir, 0777, true);

				$image->saveToFile( $dir . $new_name );

				// cria a img thumb ==========================================
				$image_thumb = WideImage::load( $tmp_name[$i] );
				$image_thumb = $image_thumb->resize(270, 162, 'outside');
				$image_thumb = $image_thumb->crop('center', 'center', 270, 162);

				$dir_thumb = $dir.'thumb/';
				// verifica so o diretorio existe
				// caso contrario, criamos o diretorio com permissao para escrita
				if( !is_dir( $dir_thumb ) )
					mkdir( $dir_thumb, 0777, true);

				$image_thumb->saveToFile( $dir_thumb . $new_name );

				// cria a img media ==========================================
				$image_media = WideImage::load( $tmp_name[$i] );
				$image_media = $image_media->resize(370, 185, 'outside');
				$image_media = $image_media->crop('center', 'center', 370, 185);

				$dir_media = $dir.'media/';
				// verifica so o diretorio existe
				// caso contrario, criamos o diretorio com permissao para escrita
				if( !is_dir( $dir_media ) )
					mkdir( $dir_media, 0777, true);

				$image_media->saveToFile( $dir_media . $new_name );

			}
		}

		echo json_encode($new_name);

	}
}
