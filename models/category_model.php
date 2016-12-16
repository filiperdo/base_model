<?php

/**
 * Classe Category
 * @author __
 *
 * Data: 13/09/2016
 */

include_once 'typecategory_model.php';

class Category_Model extends Model
{
	/**
	* Atributos Private
	*/
	private $id_category;
	private $name;
	private $typecategory;

	public function __construct()
	{
		parent::__construct();

		$this->id_category = '';
		$this->name = '';
		$this->typecategory = new Typecategory_Model();
	}

	/**
	* Metodos set's
	*/
	public function setId_category( $id_category )
	{
		$this->id_category = $id_category;
	}

	public function setName( $name )
	{
		$this->name = $name;
	}

	public function setTypecategory( Typecategory_Model $typecategory )
	{
		$this->typecategory = $typecategory;
	}

	/**
	* Metodos get's
	*/
	public function getId_category()
	{
		return $this->id_category;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getTypecategory()
	{
		return $this->typecategory;
	}


	/**
	* Metodo create
	*/
	public function create( $data )
	{
		$this->db->beginTransaction();

		if( !$id = $this->db->insert( "category", $data ) ){
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

		if( !$update = $this->db->update("category", $data, "id_category = {$id} ") ){
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

		if( !$delete = $this->db->delete("category", "id_category = {$id} ") ){
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/**
	* Metodo obterCategory
	*/
	public function obterCategory( $id_category )
	{
		$sql  = "select * ";
		$sql .= "from category ";
		$sql .= "where id_category = :id ";

		$result = $this->db->select( $sql, array("id" => $id_category) );
		return $this->montarObjeto( $result[0] );
	}

	/**
	* Metodo listarCategory
	*/
	public function listarCategory()
	{
		$sql  = "select * ";
		$sql .= "from category ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where name like :name "; // Configurar o like com o campo necessario da tabela
			$result = $this->db->select( $sql, array("name" => "%{$_POST["like"]}%") );
		}
		else
			$result = $this->db->select( $sql );

		return $this->montarLista($result);
	}

	/**
	 * Lista as categorias vinculadas a um projetos
	 * @param unknown $id_post
	 */
	public function listCategoryByPost( $id_post )
	{
		$sql  = "select c.* ";
		$sql .= "from category as c ";
		$sql .= "inner join post_category as pc ";
		$sql .= "on pc.id_category = c.id_category ";
		$sql .= "where pc.id_post = :id_p ";

		$result = $this->db->select( $sql, array("id_p" => $id_post ) );

		return $this->montarLista($result);
	}

	/**
	 * Lista as categorias vinculadas a um projetos
	 * @param unknown $id_post
	 */
	public function listCategoryByProduct( $id_product )
	{
		$sql  = "select c.* ";
		$sql .= "from category as c ";
		$sql .= "inner join product_category as pc ";
		$sql .= "on pc.id_category = c.id_category ";
		$sql .= "where pc.id_product = :id_p ";

		$result = $this->db->select( $sql, array("id_p" => $id_product ) );
	
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
		$this->setId_category( $row["id_category"] );
		$this->setName( $row["name"] );

		$objTypecategory = new Typecategory_Model();
		$objTypecategory->obterTypecategory( $row["id_typecategory"] );
		$this->setTypecategory( $objTypecategory );

		return $this;
	}
}
?>
