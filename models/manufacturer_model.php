<?php 

/** 
 * Classe Manufacturer
 * @author __ 
 *
 * Data: 16/12/2016
 */ 


class Manufacturer_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_manufacturer;
	private $name;

	public function __construct()
	{
		parent::__construct();

		$this->id_manufacturer = '';
		$this->name = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_manufacturer( $id_manufacturer )
	{
		$this->id_manufacturer = $id_manufacturer;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	/** 
	* Metodos get's
	*/
	public function getId_manufacturer()
	{
		return $this->id_manufacturer;
	}

	public function getName()
	{
		return $this->name;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "manufacturer", $data ) ){
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

		if( !$update = $this->db->update("manufacturer", $data, "id_manufacturer = {$id} ") ){
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

		if( !$delete = $this->db->delete("manufacturer", "id_manufacturer = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterManufacturer
	*/
	public function obterManufacturer( $id_manufacturer )
	{
		$sql  = "select * ";
		$sql .= "from manufacturer ";
		$sql .= "where id_manufacturer = :id ";

		$result = $this->db->select( $sql, array("id" => $id_manufacturer) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarManufacturer
	*/
	public function listarManufacturer()
	{
		$sql  = "select * ";
		$sql .= "from manufacturer ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_manufacturer like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_manufacturer( $row["id_manufacturer"] );
		$this->setName( $row["name"] );

		return $this;
	}
}
?>