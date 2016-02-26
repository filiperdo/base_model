<?php

include_once '../config.php';

class Backup
{
	private $pdo;
	
	private $host;
	private $user;
	private $password;
	private $dbname;
	
	public function __construct()
	{
		$this->host = DB_SERVER;
        $this->user = DB_USERNAME;
        $this->password = DB_PASSWORD;
        $this->dbname = DB_NAME;
        
        try{
        	$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
        }
        catch ( PDOException $e )
        {
        	echo "Erro!: " . $e->getMessage();
        }
		
		//=============================================================
		// INICIO - GERAR BACKUP DO BANCO COM SUAS TABELAS E PROCEDURES
		
		//------------------------------------
		// Cabecalho do backup
		$retorno  ="# ---------------------------------------------------------------------\n";
		$retorno .="# Sistema de backup de banco de dados MySql \n";
		$retorno .="# Data/horario: " . date('d/m/Y H:i:s')."\n";
		$retorno .="# --------------------------------------------------------------------\n";
		
		$retorno .="/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;";
		$retorno .="/*!40101 SET NAMES utf8 */;\n";
		$retorno .="/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;\n";
		$retorno .="/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;\n\n";
		
		//------------------------------------
		// Cria o banco de dados 
		$retorno .= "CREATE DATABASE IF NOT EXISTS `$this->dbname` /*!40100 DEFAULT CHARACTER SET latin1 */;\n";
		$retorno .= "USE `$this->dbname`;\n\n";
		
		//------------------------------------
		// Busca por todas as tabelas do banco
		$sql = 'SHOW TABLES';
		
		$result = $this->pdo->query( $sql );
		$result = $result->fetchAll( PDO::FETCH_ASSOC );
		
		//Para cada tabela encontrada formata os dados
		foreach( $result as $table )
		{
			$nome_tabela = $table['Tables_in_'.$this->dbname];
			
			//------------------------------------
			// Cria a tabela
			$sql = 'SHOW CREATE TABLE ' . $nome_tabela;
			
			$smt = $this->pdo->prepare( $sql );
			$smt->execute();
			$rowTable = $smt->fetch( PDO::FETCH_ASSOC );
			
			// Ordena o array para padronizar as chaves
			sort( $rowTable );
			
			$createTable = str_replace( "CREATE TABLE", "CREATE TABLE IF NOT EXISTS", $rowTable[0] );
			
			$retorno .="# Exportando dados para a tabela " . $this->dbname.".".$rowTable[1]."\n";
			$retorno .= "" . $createTable . ";\n\n";
			
			$retorno .="# Exportando dados para a tabela " . $this->dbname.".".$rowTable[1] . ": ~" . $smt->rowCount() . " linhas (aproximadamente)\n";
			
			// Desabilita as chaves da tabela para gravar os dados
			$retorno .="/*!40000 ALTER TABLE `" . $rowTable[1] . "` DISABLE KEYS */;\n";
			
			
			//------------------------------------
			// Monta as colunas da tabela
			$Query = $this->pdo->prepare( "SHOW COLUMNS FROM {$nome_tabela} " );
			$Query->execute();
			
			$retorno .= 'INSERT INTO `' . $nome_tabela . '` ( ';
			$colunas = array();
			while($e = $Query->fetch(PDO::FETCH_ASSOC))
			{
				$retorno .= "`" . $e['Field'] ."`,";
				$colunas[] = $e['Field'];
			}
			
			$retorno .= ") VALUES \n";
			
			//------------------------------------
			// Seleciona todo o conteudo da tabela
				
			$smt = $this->pdo->prepare( "SELECT * FROM {$nome_tabela} " );
			$smt->execute();
			
			$row = $smt->fetchAll( PDO::FETCH_ASSOC );
			
			foreach( $row as $key1 => $valor )
			{
				$retorno .= "(";
				foreach( $valor as $key2 => $item )
				{
					if ( isset( $item ) )
					{
						if( gettype($item) == "string" )
						{
							$item = addslashes( $item );
							$retorno .= '"' . $item . '"' ;
						}
						else
							$retorno .= $item;
					}
					else
					{
						$retorno .= '""';
					}
					
					$retorno .= ',';
					
				}
				$retorno .= ");\n";
			} 
			
			//Habilita as chaves da tabela
			$retorno .="/*!40000 ALTER TABLE `" . $rowTable[1] . "` ENABLE KEYS */;";
			$retorno .="\n\n\n";
		}
		
		$retorno .="/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;\n";
		$retorno .="/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;\n";
		$retorno .="/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n";
		
		//------------------------------------
		//Salvar o arquivo 
		/* 
		$arquivo = fopen('../backup/bkp-bd-'.date('d-m-Y').'.sql','w+');
		fwrite( $arquivo, $retorno );
		fclose( $arquivo );
		 */
		// FIM - GERAR BACKUP DO BANCO COM SUAS TABELAS E PROCEDURES
		//=============================================================
		
		echo $retorno;
	}
}

new Backup();