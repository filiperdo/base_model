<?php

class Database extends PDO
{
	private static $instance;
	
    public function __construct()
    {
        parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        
        //parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTIONS);
        $this->exec("SET NAMES 'utf8'");
        $this->exec('SET character_set_connection=utf8');
        $this->exec('SET character_set_client=utf8');
        $this->exec('SET character_set_results=utf8');
    }
    
    public static function getInstance() {
    	if (!isset(self::$instance) && is_null(self::$instance)) {
    		$c = __CLASS__;
    		self::$instance = new $c;
    	}
    
    	return self::$instance;
    }
    
    /**
     * select
     * @param string $sql An SQL string
     * @param array $array Paramters to bind
     * @param constant $fetchMode A PDO Fetch mode
     * @return mixed
     */
    public function select($sql, $array = array(), $fetchMode = PDO::FETCH_ASSOC)
    {
        $sth = $this->prepare($sql);
        
        foreach ( $array as $key => $value )
        {
        	$sth->bindValue("$key", $value);
        }
        
        $sth->execute();
        
        return $sth->fetchAll($fetchMode);
    }
    
    /**
     * insert retornando o id do ultimo registro
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     */
    public function insert( $table, $data, $return_id = true )
    {
        ksort( $data );
        
        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));
        
        $sth = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        $sth->execute();
        
        if( $return_id )
        {
	        // Seleciona o id do ultimo registro
	        $row = $this->select( "select max(id_" . $table . ") as uid from " . $table );
	        
	        // Retorna o id do ultimo registro
	        return $row[0]['uid'];
        }
        else 
        {
        	return true;
        }
		
    }
    
    /**
     * update
     * @param string $table A name of table to insert into
     * @param string $data An associative array
     * @param string $where the WHERE query part
     */
    public function update($table, $data, $where)
    {
        ksort($data);
        
        $fieldDetails = NULL;
        foreach($data as $key=> $value) {
            $fieldDetails .= "$key=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        
        //echo "UPDATE $table SET $fieldDetails WHERE $where<br/>";
        
        $sth = $this->prepare("UPDATE $table SET $fieldDetails WHERE $where");
        
        //var_dump( $data );
        //var_dump( $where );
        
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        
        return $sth->execute();
        
        //var_dump( $result );
        //exit();
    }
    
    /**
     * delete
     * 
     * @param string $table
     * @param string $where
     * @param integer $limit
     * @return integer Affected Rows
     */
    public function delete($table, $where, $limit = 1)
    {
        return $this->exec("DELETE FROM $table WHERE $where LIMIT $limit");
    }
    
    
    /**
     * deleteComposityKey
     * @param unknown $table
     * @param unknown $where
     * @return number
     */
    public function deleteComposityKey( $table, $where )
    {
    	return $this->exec("DELETE FROM {$table} WHERE {$where} ");
    }
    
}