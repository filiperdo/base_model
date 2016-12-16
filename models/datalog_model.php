<?php

/**
 * Classe Datalog
 * @author __
 *
 * Data: 01/06/2016
 */

include_once 'post_model.php';
include_once 'user_model.php';

class Datalog_Model extends Model
{
	/**
	* Atributos Private
	*/
	private $id_datalog;
	private $date;
	private $user;
	private $post;

	private $ip;
	private $source;

	public function __construct()
	{
		parent::__construct();

		$this->id_datalog = '';
		$this->date = '';
		$this->user = new User_Model();
		$this->post = new Post_Model();

		$this->ip = '';
		$this->source = '';
	}

	/**
	* Metodos set's
	*/
	public function setId_datalog( $id_datalog )
	{
		$this->id_datalog = $id_datalog;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	public function setPost( Post_Model $post )
	{
		$this->post = $post;
	}


	public function setIp( $ip )
	{
		$this->ip = $ip;
	}

	public function setSource( $source )
	{
		$this->source = $source;
	}

	/**
	* Metodos get's
	*/
	public function getId_datalog()
	{
		return $this->id_datalog;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPost()
	{
		return $this->post;
	}

	public function getIp()
	{
		return $this->ip;
	}

	public function getSource()
	{
		return $this->source;
	}

	/**
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		// Retira estas chaves do array, foram utilizadas para
		// efetuar a pesquisa de um data log especifico antes de gravar
		unset( $data['id'] );
		unset( $data['date'] );
		unset( $data['type'] );

		// Configura a origem do acesso
		$data['source'] = '';//$_SERVER['HTTP_REFERER'];

		// Verifica se o user esta logado para gravar o id
		Session::init();
		if( Session::get('userid') )
		{
			$data['id_user'] = Session::get('userid');
		}

		//var_dump( $data );
		if( !$id = $this->db->insert( "datalog", $data ) ){
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

		if( !$update = $this->db->update("datalog", $data, "id_datalog = {$id} ") ){
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

		if( !$delete = $this->db->delete("datalog", "id_datalog = {$id} ") ){
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/**
	* Metodo obterDatalog
	*/
	public function obterDatalog( $id_datalog )
	{
		$sql  = "select * ";
		$sql .= "from datalog ";
		$sql .= "where id_datalog = :id ";

		$result = $this->db->select( $sql, array("id" => $id_datalog) );
		return $this->montarObjeto( $result[0] );
	}

	/**
	 * Verifica se ja existe um log expecifico
	 * @param unknown $dados
	 */
	public function getDataLog( $dados ) // $id, $ip, $data, $type
	{
		$sql  = "select * ";
		$sql .= "from datalog as d ";
		$sql .= 'where ip = "'. $dados['ip'] . '" ';
		$sql .= "and date(d.date) = '" . date('Y-m-d') . "' ";
		$sql .= "and {$dados['type']} = '{$dados['id']}' ";

		$result = $this->db->select( $sql );

		if( !empty( $result ) )
			return true;
		else
			return false;
	}

	/**
	 * Conta quantas visualizações exitem
	 * para um determinado item
	 * @param unknown $id
	 * @param unknown $type
	 */
	public function countDataLog( $id, $type )
	{
		$sql  = "select count(id_datalog) as total ";
		$sql .= "from datalog ";
		$sql .= "where id_{$type} = :id ";

		$result = $this->db->select( $sql, array("id" => $id) );
		return $result[0]['total'];
	}

	/**
	* Metodo listarDatalog
	*/
	public function listarDatalog()
	{
		$sql  = "select * ";
		$sql .= "from datalog ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where id_datalog like :id "; // Configurar o like com o campo necessario da tabela
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
		$this->setId_datalog( $row["id_datalog"] );
		$this->setDate( $row["date"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row["id_user"] );
		$this->setUser( $objUser );

		$objPost = new Post_Model();
		$objPost->obterPost( $row["id_post"] );
		$this->setPost( $objPost );

		$this->setIp( $row["ip"] );
		$this->setSource( $row['source'] );

		return $this;
	}
}
?>
