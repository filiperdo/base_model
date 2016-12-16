<?php 

/** 
 * Classe Stock
 * @author __ 
 *
 * Data: 16/12/2016
 */ 

include_once 'product_model.php';

class Stock_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_stock;
	private $amount;
	private $min;
	private $max;
	private $date;
	private $product;

	public function __construct()
	{
		parent::__construct();

		$this->id_stock = '';
		$this->amount = '';
		$this->min = '';
		$this->max = '';
		$this->date = '';
		$this->product = new Product_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setId_stock( $id_stock )
	{
		$this->id_stock = $id_stock;
	}

	public function setAmount( $amount )
	{
		$this->amount = $amount;
	}

	public function setMin( $min )
	{
		$this->min = $min;
	}

	public function setMax( $max )
	{
		$this->max = $max;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setProduct( Product_Model $product )
	{
		$this->product = $product;
	}

	/** 
	* Metodos get's
	*/
	public function getId_stock()
	{
		return $this->id_stock;
	}

	public function getAmount()
	{
		return $this->amount;
	}

	public function getMin()
	{
		return $this->min;
	}

	public function getMax()
	{
		return $this->max;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getProduct()
	{
		return $this->product;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "stock", $data ) ){
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

		if( !$update = $this->db->update("stock", $data, "id_stock = {$id} ") ){
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

		if( !$delete = $this->db->delete("stock", "id_stock = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterStock
	*/
	public function obterStock( $id_stock )
	{
		$sql  = "select * ";
		$sql .= "from stock ";
		$sql .= "where id_stock = :id ";

		$result = $this->db->select( $sql, array("id" => $id_stock) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarStock
	*/
	public function listarStock()
	{
		$sql  = "select * ";
		$sql .= "from stock ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_stock like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_stock( $row["id_stock"] );
		$this->setAmount( $row["amount"] );
		$this->setMin( $row["min"] );
		$this->setMax( $row["max"] );
		$this->setDate( $row["date"] );

		$objProduct = new Product_Model();
		$objProduct->obterProduct( $row["id_product"] );
		$this->setProduct( $objProduct );

		return $this;
	}
}
?>