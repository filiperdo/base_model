<?php 

/** 
 * Classe Newsletter
 * @author __ 
 *
 * Data: 13/09/2016
 */ 


class Newsletter_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_newsletter;
	private $email;
	private $data;

	public function __construct()
	{
		parent::__construct();

		$this->id_newsletter = '';
		$this->email = '';
		$this->data = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_newsletter( $id_newsletter )
	{
		$this->id_newsletter = $id_newsletter;
	}

	public function setEmail( $email )
	{
		$this->email = $email;
	}

	public function setData( $data )
	{
		$this->data = $data;
	}

	/** 
	* Metodos get's
	*/
	public function getId_newsletter()
	{
		return $this->id_newsletter;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getData()
	{
		return $this->data;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "newsletter", $data ) ){
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

		if( !$update = $this->db->update("newsletter", $data, "id_newsletter = {$id} ") ){
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

		if( !$delete = $this->db->delete("newsletter", "id_newsletter = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterNewsletter
	*/
	public function obterNewsletter( $id_newsletter )
	{
		$sql  = "select * ";
		$sql .= "from newsletter ";
		$sql .= "where id_newsletter = :id ";

		$result = $this->db->select( $sql, array("id" => $id_newsletter) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarNewsletter
	*/
	public function listarNewsletter()
	{
		$sql  = "select * ";
		$sql .= "from newsletter ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_newsletter like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_newsletter( $row["id_newsletter"] );
		$this->setEmail( $row["email"] );
		$this->setData( $row["data"] );

		return $this;
	}
}
?>