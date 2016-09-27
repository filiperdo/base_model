<?php 

/** 
 * Classe Typeuser_permission
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'typeuser_model.php';
include_once 'permission_model.php';

class Typeuser_permission_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $typeuser;
	private $permission;

	public function __construct()
	{
		parent::__construct();

		$this->typeuser = new Typeuser_Model();
		$this->permission = new Permission_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setTypeuser( Typeuser_Model $typeuser )
	{
		$this->typeuser = $typeuser;
	}

	public function setPermission( Permission_Model $permission )
	{
		$this->permission = $permission;
	}

	/** 
	* Metodos get's
	*/
	public function getTypeuser()
	{
		return $this->typeuser;
	}

	public function getPermission()
	{
		return $this->permission;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "typeuser_permission", $data ) ){
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

		if( !$update = $this->db->update("typeuser_permission", $data, "id_typeuser_permission = {$id} ") ){
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

		if( !$delete = $this->db->delete("typeuser_permission", "id_typeuser_permission = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterTypeuser_permission
	*/
	public function obterTypeuser_permission( $id_typeuser_permission )
	{
		$sql  = "select * ";
		$sql .= "from typeuser_permission ";
		$sql .= "where id_typeuser_permission = :id ";

		$result = $this->db->select( $sql, array("id" => $id_typeuser_permission) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarTypeuser_permission
	*/
	public function listarTypeuser_permission()
	{
		$sql  = "select * ";
		$sql .= "from typeuser_permission ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_typeuser_permission like :id "; // Configurar o like com o campo necessario da tabela 
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

		$objTypeuser = new Typeuser_Model();
		$objTypeuser->obterTypeuser( $row["id_typeuser"] );
		$this->setTypeuser( $objTypeuser );

		$objPermission = new Permission_Model();
		$objPermission->obterPermission( $row["id_permission"] );
		$this->setPermission( $objPermission );

		return $this;
	}
}
?>