<?php 

/** 
 * Classe Datalog
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'user_model.php';
include_once 'post_model.php';
include_once 'product_model.php';

class Datalog_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_datalog;
	private $date;
	private $user;
	private $post;
	private $product;
	private $ip;

	public function __construct()
	{
		parent::__construct();

		$this->id_datalog = '';
		$this->date = '';
		$this->user = new User_Model();
		$this->post = new Post_Model();
		$this->product = new Product_Model();
		$this->ip = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_datalog( $id_datalog )
	{
		$this->id_datalog = $id_datalog;
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

	public function setProduct( Product_Model $product )
	{
		$this->product = $product;
	}

	public function setIp( $ip )
	{
		$this->ip = $ip;
	}

	/** 
	* Metodos get's
	*/
	public function getId_datalog()
	{
		return $this->id_datalog;
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

	public function getProduct()
	{
		return $this->product;
	}

	public function getIp()
	{
		return $this->ip;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "datalog", $data ) ){
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

		if( !$update = $this->db->update("datalog", $data, "id_datalog = {$id} ") ){
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

		if( !$delete = $this->db->delete("datalog", "id_datalog = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterDatalog
	*/
	public function obterDatalog( $id_datalog )
	{
		$sql  = "select * ";
		$sql .= "from datalog ";
		$sql .= "where id_datalog = :id ";

		$result = $this->db->select( $sql, array("id" => $id_datalog) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarDatalog
	*/
	public function listarDatalog()
	{
		$sql  = "select * ";
		$sql .= "from datalog ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_datalog like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_datalog( $row["id_datalog"] );
		$this->setDate( $row["date"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );

		$objPost = new Post_Model();
		$objPost->obterPost( $row["id_post"] );
		$this->setPost( $objPost );

		$objProduct = new Product_Model();
		$objProduct->obterProduct( $row["id_product"] );
		$this->setProduct( $objProduct );
		$this->setIp( $row["ip"] );

		return $this;
	}
}
?>