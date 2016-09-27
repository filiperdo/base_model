<?php 

/** 
 * Classe Typeuser
 * @author __ 
 *
 * Data: 13/09/2016
 */ 


class Typeuser_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_typeuser;
	private $name;

	public function __construct()
	{
		parent::__construct();

		$this->id_typeuser = '';
		$this->name = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_typeuser( $id_typeuser )
	{
		$this->id_typeuser = $id_typeuser;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	/** 
	* Metodos get's
	*/
	public function getId_typeuser()
	{
		return $this->id_typeuser;
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

		if( !$id = $this->db->insert( "typeuser", $data ) ){
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

		if( !$update = $this->db->update("typeuser", $data, "id_typeuser = {$id} ") ){
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

		if( !$delete = $this->db->delete("typeuser", "id_typeuser = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterTypeuser
	*/
	public function obterTypeuser( $id_typeuser )
	{
		$sql  = "select * ";
		$sql .= "from typeuser ";
		$sql .= "where id_typeuser = :id ";

		$result = $this->db->select( $sql, array("id" => $id_typeuser) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarTypeuser
	*/
	public function listarTypeuser()
	{
		$sql  = "select * ";
		$sql .= "from typeuser ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_typeuser like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_typeuser( $row["id_typeuser"] );
		$this->setName( $row["name"] );

		return $this;
	}
}
?>