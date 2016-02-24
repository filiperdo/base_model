<?php 


 
/** 
 * Classe Tipodesafio
 * @author __ 
 *
 * Data: 13/01/2016
 */
class Tipodesafio_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $tipodesafio;
	public $descricao;
	public $file;

	public function __construct()
	{
		parent::__construct();

		$this->id_tipodesafio = '';
		$this->descricao = '';
		$this->file = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_tipodesafio( $id_tipodesafio )
	{
		$this->id_tipodesafio = $id_tipodesafio;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	public function setFile( $file )
	{
		$this->file = $file;
	}

	/** 
	* Metodos get's
	*/
	public function getId_tipodesafio()
	{
		return $this->id_tipodesafio;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}

	public function getFile()
	{
		return $this->file;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();
		
		if( !$id_tipodesafio = $this->db->insert("tipodesafio", $data) )
		{
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
		
		if( !$update = $this->db->update("tipodesafio", $data, "id_tipodesafio = {$id} ") )
		{
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
		
		if( !$delete = $this->db->delete("tipodesafio", "id_tipodesafio = {$id} ") )
		{
			$this->db->rollBack();
			return false;
		}
		
		$this->db->commit();
		
		return $delete;
	}

	/** 
	* Metodo obterTipodesafio
	*/
	public function obterTipodesafio( $id_tipodesafio ) // refazer esta parte no install-mvc
	{
		//$result = $this->db->obterRegistroPorId( "tipodesafio", $id_tipodesafio );
		
		$sql  = "select * ";
		$sql .= "from tipodesafio ";
		$sql .= 'where id_tipodesafio = :id ';
		
		$result = $this->db->select( $sql, array('id' => $id_tipodesafio) );
		
		return $this->montarObjeto( $result[0] );
	}
	
	/** 
	* Metodo listarTipodesafio
	*/
	public function listarTipodesafio()
	{
		$sql  = "select * ";
		$sql .= "from tipodesafio ";
		
		if( isset( $_POST['like'] ) )
		{
			$sql .= "where id_tipodesafio like :id ";
			$result = $this->db->select( $sql, array('id' => "%{$_POST['like']}%") );
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
		$this->setId_tipodesafio( $row["id_tipodesafio"] );
		$this->setDescricao( $row["descricao"] );
		$this->setFile( $row["file"] );
		
		return $this; // Adicionar esta parte no install-mvc
	}
}
?>