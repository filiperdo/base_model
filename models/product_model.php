<?php 

/** 
 * Classe Product
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'user_model.php';

class Product_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_product;
	private $name;
	private $description;
	private $data;
	private $user;
	private $status;
	private $path;
	private $mainpicture;
	private $slug;
	private $price;
	private $amount;

	public function __construct()
	{
		parent::__construct();

		$this->id_product = '';
		$this->name = '';
		$this->description = '';
		$this->data = '';
		$this->user = new User_Model();
		$this->status = '';
		$this->path = '';
		$this->mainpicture = '';
		$this->slug = '';
		$this->price = '';
		$this->amount = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_product( $id_product )
	{
		$this->id_product = $id_product;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	public function setDescription( $description )
	{
		$this->description = $description;
	}

	public function setData( $data )
	{
		$this->data = $data;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setPath( $path )
	{
		$this->path = $path;
	}

	public function setMainpicture( $mainpicture )
	{
		$this->mainpicture = $mainpicture;
	}

	public function setSlug( $slug )
	{
		$this->slug = $slug;
	}

	public function setPrice( $price )
	{
		$this->price = $price;
	}

	public function setAmount( $amount )
	{
		$this->amount = $amount;
	}

	/** 
	* Metodos get's
	*/
	public function getId_product()
	{
		return $this->id_product;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getData()
	{
		return $this->data;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getMainpicture()
	{
		return $this->mainpicture;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getAmount()
	{
		return $this->amount;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "product", $data ) ){
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

		if( !$update = $this->db->update("product", $data, "id_product = {$id} ") ){
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

		if( !$delete = $this->db->delete("product", "id_product = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterProduct
	*/
	public function obterProduct( $id_product )
	{
		$sql  = "select * ";
		$sql .= "from product ";
		$sql .= "where id_product = :id ";

		$result = $this->db->select( $sql, array("id" => $id_product) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarProduct
	*/
	public function listarProduct()
	{
		$sql  = "select * ";
		$sql .= "from product ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where name like :name "; // Configurar o like com o campo necessario da tabela 
			$result = $this->db->select( $sql, array("name" => "%{$_POST["like"]}%") );
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
		$this->setId_product( $row["id_product"] );
		$this->setName( $row["name"] );
		$this->setDescription( $row["description"] );
		$this->setData( $row["data"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );
		$this->setStatus( $row["status"] );
		$this->setPath( $row["path"] );
		$this->setMainpicture( $row["mainpicture"] );
		$this->setSlug( $row["slug"] );
		$this->setPrice( $row["price"] );
		$this->setAmount( $row["amount"] );

		return $this;
	}
}
?>