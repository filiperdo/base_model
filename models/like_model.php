<?php 

/** 
 * Classe Like
 * @author __ 
 *
 * Data: 13/09/2016
 */ 


class Like_Model extends Model
{
	/** 
	* Atributos Private 
	*/

	public function __construct()
	{
		parent::__construct();

	}

	/** 
	* Metodos set's
	*/
	/** 
	* Metodos get's
	*/

	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "like", $data ) ){
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

		if( !$update = $this->db->update("like", $data, "id_like = {$id} ") ){
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

		if( !$delete = $this->db->delete("like", "id_like = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterLike
	*/
	public function obterLike( $id_like )
	{
		$sql  = "select * ";
		$sql .= "from like ";
		$sql .= "where id_like = :id ";

		$result = $this->db->select( $sql, array("id" => $id_like) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarLike
	*/
	public function listarLike()
	{
		$sql  = "select * ";
		$sql .= "from like ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_like like :id "; // Configurar o like com o campo necessario da tabela 
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

		return $this;
	}
}
?>