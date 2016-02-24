<?php 

/** 
 * Classe Ano
 * @author __ 
 *
 * Data: 13/01/2016
 */
class Ano_Model extends Model
{
	/** 
	* Atributos Private 
	*/
	private $ano;
	private $descricao;

	public function __construct()
	{
		parent::__construct();

		$this->id_ano = '';
		$this->descricao = '';
	}

	/** 
	* Metodos set's
	*/
	public function setId_ano( $id_ano )
	{
		$this->id_ano = $id_ano;
	}

	public function setDescricao( $descricao )
	{
		$this->descricao = $descricao;
	}

	/** 
	* Metodos get's
	*/
	public function getId_ano()
	{
		return $this->id_ano;
	}

	public function getDescricao()
	{
		return $this->descricao;
	}


	/** 
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->insert("ano", array(
			//'id_ano' 		=> $data["id_ano"],
			'descricao' 		=> $data["descricao"],
		));
	}

	/** 
	* Metodo edit
	*/
	public function edit( $data )
	{
		$postData = array(
			'id_ano' => $data["id_ano"],
			'descricao' => $data["descricao"],
		);

		$this->db->update("ano", $postData, "id_ano = {$data['id_ano']} ");
	}

	/** 
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->db->delete("ano", "id_ano = {$id} ");
	}

	/** 
	* Metodo obterAno
	*/
	public function obterAno( $id_ano )
	{
		$result = $this->db->obterRegistroPorId( "ano", $id_ano );
		return $this->montarObjeto( $result->fetch_array() );
	}

	/** 
	* Metodo listarAno
	*/
	public function listarAno( Paginacao $objPaginacao = NULL )
	{
		$sql  = "select * ";
		$sql .= "from ano ";

		if ($objPaginacao)
		{
			$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();
		}

		$result = $this->db->executarSQL($sql);

		if ( $result->num_rows > 0 )
			return $this->montarLista($result);
		else
			return array();
	}

	/** 
	* Metodo montarLista
	*/
	private function montarLista( $result )
	{
		if( $result->num_rows > 0 )
		{
			while( $row = $result->fetch_array() )
			{
				$obj = new self();
				$obj->montarObjeto( $row );
				$objs[] = $obj;
				$obj = null;
			}
			return $objs;
		}
		else
		{
			return false;
		}
	}

	/** 
	* Metodo montarObjeto
	*/
	private function montarObjeto( $row )
	{
		$this->setId_ano( $row["id_ano"] );
		$this->setDescricao( $row["descricao"] );
	}
}
?>