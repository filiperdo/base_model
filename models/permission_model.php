<?php 

/** 
 * Classe Permission
 * @author __ 
 *
 * Data: 13/09/2016
 */ 


class Permission_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_permission;
	private $name;

	public function __construct()
	{
		parent::__construct();

		$this->id_permission = '';
		$this->name = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_permission( $id_permission )
	{
		$this->id_permission = $id_permission;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	/** 
	* Metodos get's
	*/
	public function getId_permission()
	{
		return $this->id_permission;
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

		if( !$id = $this->db->insert( "permission", $data ) ){
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

		if( !$update = $this->db->update("permission", $data, "id_permission = {$id} ") ){
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

		if( !$delete = $this->db->delete("permission", "id_permission = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterPermission
	*/
	public function obterPermission( $id_permission )
	{
		$sql  = "select * ";
		$sql .= "from permission ";
		$sql .= "where id_permission = :id ";

		$result = $this->db->select( $sql, array("id" => $id_permission) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarPermission
	*/
	public function listarPermission()
	{
		$sql  = "select * ";
		$sql .= "from permission ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_permission like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_permission( $row["id_permission"] );
		$this->setName( $row["name"] );

		return $this;
	}
}
?>