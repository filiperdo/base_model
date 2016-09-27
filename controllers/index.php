<?php 

class Index extends Controller {

	public function __construct() {
		parent::__construct();
		Auth::handleLogin();
	}

	/** 
	* Metodo index
	*/
	public function index()
	{
		$this->view->title = "Index";

		$this->view->render( "header" );
		$this->view->render( "index/index" );
		$this->view->render( "footer" );
	}
}