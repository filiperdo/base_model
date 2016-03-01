<?php 

/** 
 * Classe Post
 * @author __ 
 *
 * Data: 01/03/2016
 */
class Post_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $post;
	private $content;
	private $date;
	private $views;
	private $typepost;
	private $user;

	public function __construct()
	{
		parent::__construct();

		$this->id_post = '';
		$this->content = '';
		$this->date = '';
		$this->views = '';
		$this->id_typepost = '';
		$this->id_user = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_post( $id_post )
	{
		$this->id_post = $id_post;
	}

	public function setContent( $content )
	{
		$this->content = $content;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setViews( $views )
	{
		$this->views = $views;
	}

	public function setId_typepost( $id_typepost )
	{
		$this->id_typepost = $id_typepost;
	}

	public function setId_user( $id_user )
	{
		$this->id_user = $id_user;
	}

	/** 
	* Metodos get's
	*/
	public function getId_post()
	{
		return $this->id_post;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getViews()
	{
		return $this->views;
	}

	public function getId_typepost()
	{
		return $this->id_typepost;
	}

	public function getId_user()
	{
		return $this->id_user;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "post", $data ) ){
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

		if( !$update = $this->db->update("post", $data, "id_post = {$id} ") ){
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

		if( !$delete = $this->db->delete("post", "id_post = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterPost
	*/
	public function obterPost( $id_post )
	{
		$sql  = "select * ";
		$sql .= "from post ";
		$sql .= "where id_post = :id ";

		$result = $this->db->select( $sql, array("id" => $id_post) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarPost
	*/
	public function listarPost()
	{
		$sql  = "select * ";
		$sql .= "from post ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_post like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_post( $row["id_post"] );
		$this->setContent( $row["content"] );
		$this->setDate( $row["date"] );
		$this->setViews( $row["views"] );
		$this->setId_typepost( $row["id_typepost"] );
		$this->setId_user( $row["id_user"] );

		return $this;
	}
}
?>