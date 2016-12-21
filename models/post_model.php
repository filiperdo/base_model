<?php

/**
 * Classe Post
 * @author __
 *
 * Data: 01/06/2016
 */
require_once 'models/user_model.php';


class Post_Model extends Model
{
	/**
	* Atributos Private
	*/
	private $id_post;
	private $title;
	private $content;
	private $date;
	private $views;
	private $status;
	private $user;
	private $path;
	private $mainpicture;
	private $type; // post, page
	private $slug;
	private $author;
	private $source;
	private $tags;

	public function __construct()
	{
		parent::__construct();

		$this->id_post = '';
		$this->title = '';
		$this->content = '';
		$this->date = '';
		$this->views = '';
		$this->status = '';
		$this->user = new User_Model();
		$this->path = '';
		$this->mainpicture = '';
		$this->type = '';
		$this->slug = '';
		$this->author = '';
		$this->source = '';
		$this->tags = '';
	}

	/**
	* Metodos set's
	*/
	public function setId_post( $id_post )
	{
		$this->id_post = $id_post;
	}

	public function setTitle( $title )
	{
		$this->title = $title;
	}

	public function setContent( $content )
	{
		$this->content = $content;
	}

	public function setDate( $date )
	{
		$this->date = $date;
	}

	public function setViews( $views )
	{
		$this->views = $views;
	}

	public function setStatus( $status )
	{
		$this->status = $status;
	}

	public function setUser( User_Model $user )
	{
		$this->user = $user;
	}

	public function setPath( $path )
	{
		$this->path = $path;
	}

	public function setMainpicture( $mainpicture )
	{
		$this->mainpicture = $mainpicture;
	}

	public function setType( $type )
	{
		$this->type = $type;
	}

	public function setSlug( $slug )
	{
		$this->slug = $slug;
	}

	public function setAuthor( $author )
	{
		$this->author = $author;
	}

	public function setSource( $source )
	{
		$this->source = $source;
	}

	public function setTags( $tags )
	{
		$this->tags = $tags;
	}

	/**
	* Metodos get's
	*/
	public function getId_post()
	{
		return $this->id_post;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function getDate()
	{
		return $this->date;
	}

	public function getViews()
	{
		return $this->views;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getUser()
	{
		return $this->user;
	}

	public function getPath()
	{
		return $this->path;
	}

	public function getMainpicture()
	{
		return $this->mainpicture;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function getAuthor()
	{
		return $this->author;
	}

	public function getSource()
	{
		return $this->source;
	}

	public function getTags()
	{
		return $this->tags;
	}

	/**
	* Metodo create
	*/
	public function create( $data )
	{
		//$this->db->beginTransaction();

		if( !$id = $this->db->insert( "post", $data ) ){
			$this->db->rollBack();
			return false;
		}

		//$this->db->commit();
		return $id;
	}

	/**
	* Metodo edit
	*/
	public function edit( $data, $id )
	{
		//$this->db->beginTransaction();

		if( !$update = $this->db->update("post", $data, "id_post = {$id} ") ){
			$this->db->rollBack();
			return false;
		}

		//$this->db->commit();
		return $update;
	}

	/**
	* Metodo delete
	*/
	public function delete( $id )
	{
		$this->db->beginTransaction();

		if( !$delete = $this->db->delete("post", "id_post = {$id} ") ){
			$this->db->rollBack();
			return false;
		}

		$this->db->commit();
		return $delete;
	}

	/**
	* Metodo obterPost
	*/
	public function obterPost( $id_post )
	{
		$sql  = "select * ";
		$sql .= "from post ";
		$sql .= "where id_post = :id ";

		$result = $this->db->select( $sql, array("id" => $id_post) );
		return $this->montarObjeto( $result[0] );
	}

	/**
	 * Metodo obterPostBySlug
	 */
	public function obterPostBySlug( $slug )
	{
		$sql  = "select * ";
		$sql .= "from post ";
		$sql .= "where slug = :slug ";

		$result = $this->db->select( $sql, array("slug" => $slug) );
		return $this->montarObjeto( $result[0] );
	}

	/**
	* Metodo listarPost
	*/
	public function listarPost()
	{
		$sql  = "select * ";
		$sql .= "from post ";

		if ( isset( $_POST["like"] ) )
		{
			$sql .= "where title like :id "; // Configurar o like com o campo necessario da tabela
			$sql .= "order by date desc ";
			$result = $this->db->select( $sql, array("id" => "%{$_POST["like"]}%") );
		}
		else
		{
			$sql .= "order by date desc ";
			$result = $this->db->select( $sql );
		}

		return $this->montarLista($result);
	}

	/**
	 * Lista os posts mais lidos
	 * @param unknown $limit
	 */
	public function listTopPost( $limit = NULL )
	{
		$sql  = "select ";
		$sql .= "p.*, ";
		$sql .= "(select count(d.id_post) from datalog as d where d.id_post = p.id_post) as total ";
		$sql .= "from post as p ";
		$sql .= "where p.status = 'PUBLISHED' ";
		$sql .= "order by total desc ";

		if( $limit )
			$sql .= "limit {$limit} ";

		$result = $this->db->select( $sql );

		return $this->montarLista($result);
	}

	/**
	 * Lista os posts para a home
	 * filtrando apenas os publicados
	 */
	public function listPostHome( $limit = false )
	{
		$sql  = "select * ";
		$sql .= "from post as p ";
		$sql .= "where p.status = 'PUBLISHED' ";
		$sql .= "order by p.date desc ";

		if( $limit )
			$sql .= "limit {$limit} ";

		$result = $this->db->select( $sql );

		return $this->montarLista($result);
	}


	/**
	 * Metodo listPostRelated
	 * Lista os post relacionados com outro post
	 * Filtrando pela igualdade das categorias
	 * @param array $category
	 * @param unknown $limit
	 */
	public function listPostRelated( $id_post, Array $category, $limit = NULL )
	{
		$sql  = "select p.* ";
		$sql .= "from post as p ";
		$sql .= "inner join post_category as pc ";
		$sql .= "on pc.id_post = p.id_post ";
		$sql .= "where pc.id_category in (" . implode( ',', $category ) . ") ";
		$sql .= "and p.status = 'PUBLISHED' ";
		$sql .= "and p.id_post != {$id_post} ";
		$sql .= "group by p.id_post ";
		$sql .= "order by p.views desc ";

		if( $limit )
			$sql .= "limit {$limit} ";

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
		$this->setId_post( $row["id_post"] );
		$this->setTitle( $row["title"] );
		$this->setContent( $row["content"] );
		$this->setDate( $row["date"] );
		$this->setViews( $row["views"] );
		$this->setStatus( $row["status"] );

		$objUser = new User_Model();
		$objUser->obterUser( $row['id_user'] );
		$this->setUser( $objUser );

		$this->setPath( $row['path'] ) ;
		$this->setMainpicture( $row['mainpicture'] );
		$this->setType( $row['type'] );
		$this->setSlug( $row['slug'] );
		$this->setAuthor( $row['author'] );
		$this->setSource( $row['source'] );
		$this->setTags( $row['tags'] );

		return $this;
	}
}
?>
