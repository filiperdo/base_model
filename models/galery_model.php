<?php 

/** 
 * Classe Galery
 * @author __ 
 *
 * Data: 16/12/2016
 */ 

include_once 'user_model.php';

class Galery_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_galery;
	private $name;
	private $slug;
	private $path;
	private $mainpicture;
	private $date;
	private $user;

	public function __construct()
	{
		parent::__construct();

		$this->id_galery = '';
		$this->name = '';
		$this->slug = '';
		$this->path = '';
		$this->mainpicture = '';
		$this->date = '';
		$this->user = new User_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setId_galery( $id_galery )
	{
		$this->id_galery = $id_galery;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	public function setSlug( $slug )
	{
		$this->slug = $slug;
	}

	public function setPath( $path )
	{
		$this->path = $path;
	}

	public function setMainpicture( $mainpicture )
	{
		$this->mainpicture = $mainpicture;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	/** 
	* Metodos get's
	*/
	public function getId_galery()
	{
		return $this->id_galery;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getMainpicture()
	{
		return $this->mainpicture;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getUser()
	{
		return $this->user;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "galery", $data ) ){
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

		if( !$update = $this->db->update("galery", $data, "id_galery = {$id} ") ){
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

		if( !$delete = $this->db->delete("galery", "id_galery = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterGalery
	*/
	public function obterGalery( $id_galery )
	{
		$sql  = "select * ";
		$sql .= "from galery ";
		$sql .= "where id_galery = :id ";

		$result = $this->db->select( $sql, array("id" => $id_galery) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarGalery
	*/
	public function listarGalery()
	{
		$sql  = "select * ";
		$sql .= "from galery ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_galery like :id "; // Configurar o like com o campo necessario da tabela 
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
		$this->setId_galery( $row["id_galery"] );
		$this->setName( $row["name"] );
		$this->setSlug( $row["slug"] );
		$this->setPath( $row["path"] );
		$this->setMainpicture( $row["mainpicture"] );
		$this->setDate( $row["date"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );

		return $this;
	}
}
?>