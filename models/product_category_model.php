<?php 

/** 
 * Classe Product_category
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'product_model.php';
include_once 'category_model.php';

class Product_category_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $product;
	private $category;

	public function __construct()
	{
		parent::__construct();

		$this->product = new Product_Model();
		$this->category = new Category_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setProduct( Product_Model $product )
	{
		$this->product = $product;
	}

	public function setCategory( Category_Model $category )
	{
		$this->category = $category;
	}

	/** 
	* Metodos get's
	*/
	public function getProduct()
	{
		return $this->product;
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
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "product_category", $data ) ){
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

		if( !$update = $this->db->update("product_category", $data, "id_product_category = {$id} ") ){
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

		if( !$delete = $this->db->delete("product_category", "id_product_category = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterProduct_category
	*/
	public function obterProduct_category( $id_product_category )
	{
		$sql  = "select * ";
		$sql .= "from product_category ";
		$sql .= "where id_product_category = :id ";

		$result = $this->db->select( $sql, array("id" => $id_product_category) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarProduct_category
	*/
	public function listarProduct_category()
	{
		$sql  = "select * ";
		$sql .= "from product_category ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_product_category like :id "; // Configurar o like com o campo necessario da tabela 
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

		$objProduct = new Product_Model();
		$objProduct->obterProduct( $row["id_product"] );
		$this->setProduct( $objProduct );

		$objCategory = new Category_Model();
		$objCategory->obterCategory( $row["id_category"] );
		$this->setCategory( $objCategory );

		return $this;
	}
}
?>