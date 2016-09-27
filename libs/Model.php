<?php

include_once 'libs/Database.php';

class Model {

    function __construct( Database $bdParam = null ) {
    	
    	if ($bdParam == null) {
    		$this->db = Database::getInstance();
    	} else {
    		$this->db = $bdParam;
    	}
    	
	    //$this->db = new Database();	    
    }

}