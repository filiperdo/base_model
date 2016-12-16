<?php 

/** 
 * Classe Provider
 * @author __ 
 *
 * Data: 16/12/2016
 */ 


class Provider_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_provider;
	private $name;
	private $email;
	private $adress;
	private $phone1;
	private $phone2;

	public function __construct()
	{
		parent::__construct();

		$this->id_provider = '';
		$this->name = '';
		$this->email = '';
		$this->adress = '';
		$this->phone1 = '';
		$this->phone2 = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_provider( $id_provider )
	{
		$this->id_provider = $id_provider;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	public function setEmail( $email )
	{
		$this->email = $email;
	}

	public function setAdress( $adress )
	{
		$this->adress = $adress;
	}

	public function setPhone1( $phone1 )
	{
		$this->phone1 = $phone1;
	}

	public function setPhone2( $phone2 )
	{
		$this->phone2 = $phone2;
	}

	/** 
	* Metodos get's
	*/
	public function getId_provider()
	{
		return $this->id_provider;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getAdress()
	{
		return $this->adress;
	}

	public function getPhone1()
	{
		return $this->phone1;
	}

	public function getPhone2()
	{
		return $this->phone2;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "provider", $data ) ){
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

		if( !$update = $this->db->update("provider", $data, "id_provider = {$id} ") ){
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

		if( !$delete = $this->db->delete("provider", "id_provider = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterProvider
	*/
	public function obterProvider( $id_provider )
	{
		$sql  = "select * ";
		$sql .= "from provider ";
		$sql .= "where id_provider = :id ";

		$result = $this->db->select( $sql, array("id" => $id_provider) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarProvider
	*/
	public function listarProvider()
	{
		$sql  = "select * ";
		$sql .= "from provider ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_provider like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_provider( $row["id_provider"] );
		$this->setName( $row["name"] );
		$this->setEmail( $row["email"] );
		$this->setAdress( $row["adress"] );
		$this->setPhone1( $row["phone1"] );
		$this->setPhone2( $row["phone2"] );

		return $this;
	}
}
?>