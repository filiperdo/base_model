<?php 

/** 
 * Classe Event
 * @author __ 
 *
 * Data: 13/09/2016
 */ 

include_once 'user_model.php';

class Event_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $id_event;
	private $title;
	private $date;
	private $hour;
	private $content;
	private $path;
	private $user;

	public function __construct()
	{
		parent::__construct();

		$this->id_event = '';
		$this->title = '';
		$this->date = '';
		$this->hour = '';
		$this->content = '';
		$this->path = '';
		$this->user = new User_Model();
	}

	/** 
	* Metodos set's
	*/
	public function setId_event( $id_event )
	{
		$this->id_event = $id_event;
	}

	public function setTitle( $title )
	{
		$this->title = $title;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setHour( $hour )
	{
		$this->hour = $hour;
	}

	public function setContent( $content )
	{
		$this->content = $content;
	}

	public function setPath( $path )
	{
		$this->path = $path;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	/** 
	* Metodos get's
	*/
	public function getId_event()
	{
		return $this->id_event;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getHour()
	{
		return $this->hour;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getPath()
	{
		return $this->path;
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

		if( !$id = $this->db->insert( "event", $data ) ){
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

		if( !$update = $this->db->update("event", $data, "id_event = {$id} ") ){
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

		if( !$delete = $this->db->delete("event", "id_event = {$id} ") ){ 
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/** 
	* Metodo obterEvent
	*/
	public function obterEvent( $id_event )
	{
		$sql  = "select * ";
		$sql .= "from event ";
		$sql .= "where id_event = :id ";

		$result = $this->db->select( $sql, array("id" => $id_event) );
		return $this->montarObjeto( $result[0] );
	}

	/** 
	* Metodo listarEvent
	*/
	public function listarEvent()
	{
		$sql  = "select * ";
		$sql .= "from event ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where title like :title "; // Configurar o like com o campo necessario da tabela 
			$result = $this->db->select( $sql, array("title" => "%{$_POST["like"]}%") );
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
		$this->setId_event( $row["id_event"] );
		$this->setTitle( $row["title"] );
		$this->setDate( $row["date"] );
		$this->setHour( $row["hour"] );
		$this->setContent( $row["content"] );
		$this->setPath( $row["path"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );

		return $this;
	}
}
?>