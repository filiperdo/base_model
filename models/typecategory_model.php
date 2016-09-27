<?php 

/** 
 * Classe Typecategory
 * @author __ 
 *
 * Data: 13/09/2016
 */ 


class Typecategory_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_typecategory;
	private $name;

	public function __construct()
	{
		parent::__construct();

		$this->id_typecategory = '';
		$this->name = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_typecategory( $id_typecategory )
	{
		$this->id_typecategory = $id_typecategory;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	/** 
	* Metodos get's
	*/
	public function getId_typecategory()
	{
		return $this->id_typecategory;
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

		if( !$id = $this->db->insert( "typecategory", $data ) ){
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

		if( !$update = $this->db->update("typecategory", $data, "id_typecategory = {$id} ") ){
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

		if( !$delete = $this->db->delete("typecategory", "id_typecategory = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterTypecategory
	*/
	public function obterTypecategory( $id_typecategory )
	{
		$sql  = "select * ";
		$sql .= "from typecategory ";
		$sql .= "where id_typecategory = :id ";

		$result = $this->db->select( $sql, array("id" => $id_typecategory) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarTypecategory
	*/
	public function listarTypecategory()
	{
		$sql  = "select * ";
		$sql .= "from typecategory ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_typecategory like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_typecategory( $row["id_typecategory"] );
		$this->setName( $row["name"] );

		return $this;
	}
}
?>