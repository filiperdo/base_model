<?php 

/** 
 * Classe Comment
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'user_model.php';
include_once 'post_model.php';

class Comment_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_comment;
	private $content;
	private $date;
	private $user;
	private $post;

	public function __construct()
	{
		parent::__construct();

		$this->id_comment = '';
		$this->content = '';
		$this->date = '';
		$this->user = new User_Model();
		$this->post = new Post_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setId_comment( $id_comment )
	{
		$this->id_comment = $id_comment;
	}

	public function setContent( $content )
	{
		$this->content = $content;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	public function setPost( Post_Model $post )
	{
		$this->post = $post;
	}

	/** 
	* Metodos get's
	*/
	public function getId_comment()
	{
		return $this->id_comment;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPost()
	{
		return $this->post;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "comment", $data ) ){
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return true;
	}

	/** 
	* Metodo edit
	*/
	public function edit( $data, $id )
	{
		$this->db->beginTransaction();

		if( !$update = $this->db->update("comment", $data, "id_comment = {$id} ") ){
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $update;
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->db->beginTransaction();

		if( !$delete = $this->db->delete("comment", "id_comment = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterComment
	*/
	public function obterComment( $id_comment )
	{
		$sql  = "select * ";
		$sql .= "from comment ";
		$sql .= "where id_comment = :id ";

		$result = $this->db->select( $sql, array("id" => $id_comment) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarComment
	*/
	public function listarComment()
	{
		$sql  = "select * ";
		$sql .= "from comment ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_comment like :id "; // Configurar o like com o campo necessario da tabela 
			$result = $this->db->select( $sql, array("id" => "%{$_POST["like"]}%") );
		}
		else
			$result = $this->db->select( $sql );

		return $this->montarLista($result);
	}

	/** 
	* Metodo montarLista
	*/
	private function montarLista( $result )
	{
		$objs = array();
		if( !empty( $result ) )
		{
			foreach( $result as $row )
			{
				$obj = new self();
				$obj->montarObjeto( $row );
				$objs[] = $obj;
				$obj = null;
			}
		}
		return $objs;
	}

	/** 
	* Metodo montarObjeto
	*/
	private function montarObjeto( $row )
	{
		$this->setId_comment( $row["id_comment"] );
		$this->setContent( $row["content"] );
		$this->setDate( $row["date"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );

		$objPost = new Post_Model();
		$objPost->obterPost( $row["id_post"] );
		$this->setPost( $objPost );

		return $this;
	}
}
?>