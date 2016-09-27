<?php 

/** 
 * Classe Post_category
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'post_model.php';
include_once 'category_model.php';

class Post_category_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $post;
	private $category;

	public function __construct()
	{
		parent::__construct();

		$this->post = new Post_Model();
		$this->category = new Category_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setPost( Post_Model $post )
	{
		$this->post = $post;
	}

	public function setCategory( Category_Model $category )
	{
		$this->category = $category;
	}

	/** 
	* Metodos get's
	*/
	public function getPost()
	{
		return $this->post;
	}

	public function getCategory()
	{
		return $this->category;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		//$this->db->beginTransaction();

		if( !$id = $this->db->insert( "post_category", $data ) ){
			$this->db->rollBack();
			return false;
		}

		//$this->db->commit();
		return true;
	}

	/** 
	* Metodo edit
	*/
	public function edit( $data, $id )
	{
		$this->db->beginTransaction();

		if( !$update = $this->db->update("post_category", $data, "id_post_category = {$id} ") ){
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

		if( !$delete = $this->db->delete("post_category", "id_post_category = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterPost_category
	*/
	public function obterPost_category( $id_post_category )
	{
		$sql  = "select * ";
		$sql .= "from post_category ";
		$sql .= "where id_post_category = :id ";

		$result = $this->db->select( $sql, array("id" => $id_post_category) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarPost_category
	*/
	public function listarPost_category()
	{
		$sql  = "select * ";
		$sql .= "from post_category ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_post_category like :id "; // Configurar o like com o campo necessario da tabela 
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

		$objPost = new Post_Model();
		$objPost->obterPost( $row["id_post"] );
		$this->setPost( $objPost );

		$objCategory = new Category_Model();
		$objCategory->obterCategory( $row["id_category"] );
		$this->setCategory( $objCategory );

		return $this;
	}
}
?>