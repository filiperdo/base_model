<?php 

/** 
 * Classe Typepost
 * @author __ 
 *
 * Data: 01/03/2016
 */
class Typepost_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $typepost;
	private $name;

	public function __construct()
	{
		parent::__construct();

		$this->id_typepost = '';
		$this->name = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_typepost( $id_typepost )
	{
		$this->id_typepost = $id_typepost;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	/** 
	* Metodos get's
	*/
	public function getId_typepost()
	{
		return $this->id_typepost;
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

		if( !$id = $this->db->insert( "typepost", $data ) ){
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

		if( !$update = $this->db->update("typepost", $data, "id_typepost = {$id} ") ){
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

		if( !$delete = $this->db->delete("typepost", "id_typepost = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterTypepost
	*/
	public function obterTypepost( $id_typepost )
	{
		$sql  = "select * ";
		$sql .= "from typepost ";
		$sql .= "where id_typepost = :id ";

		$result = $this->db->select( $sql, array("id" => $id_typepost) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarTypepost
	*/
	public function listarTypepost()
	{
		$sql  = "select * ";
		$sql .= "from typepost ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_typepost like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_typepost( $row["id_typepost"] );
		$this->setName( $row["name"] );

		return $this;
	}
}
?>