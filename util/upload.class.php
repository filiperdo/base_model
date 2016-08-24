<?php
class Upload {
	
	/**
	 * PRIVATE
	 */
	private $file = array ();
	
	/**
	 * PUBLIC
	 */
	public $dir = "", $extension, $size, $id;
	
	/**
	 * Prepara os dados do $_FILES para uma variavel.
	 *
	 * @param Array $_file        	
	 */
	public function __construct($_file) {
		foreach ( $_FILES [$_file] as $key => $values ) {
			$this->file [$key] = $values;
		}
	}
	
	/**
	 * Faz o upload do arquivo
	 */
	public function makeUpload() {
		/**
		 * Caso a variavel dir, estiver vazia, ele retorna um erro
		 */
		if ($this->dir == "") {
			print ("Voce deve determinar um caminho para os arquivos.") ;
			exit ();
		}
		
		if (self::isFile ()) {
			if (self::size ( $this->size )) {
				if (self::isArray ( $this->file ["error"] )) {
					try {
						foreach ( $this->file ["error"] as $key => $error ) {
							if ($error == UPLOAD_ERR_OK) {
								/**
								 * Inicia a copia do arquivo
								 */
								$newFileName = date ( "dmYHis" ) . "_" . $this->file ["name"] [$key];
								move_uploaded_file ( $this->file ["tmp_name"] [$key], $this->dir . $newFileName );
								/**
								 * retorna o nome do arquivo, para ser salvo no banco
								 */
								return $newFileName;
							}
						}
					} catch ( Exception $ex ) {
						echo $ex->getMessage ();
					}
				} else {
					try {
						/**
						 * Inicia a copia do arquivo
						 */
						$newFileName = date ( "dmYHis" ) . "_" . $this->file ["name"];
						move_uploaded_file ( $this->file ["tmp_name"], $this->dir . $newFileName );
						/**
						 * retorna o nome do arquivo, para ser salvo no banco
						 */
						return $newFileName;
					} catch ( Exception $ex ) {
						echo $ex->getMessage ();
					}
				}
				
				header ( "Location: index.html" );
			} else {
				print ("O(s) arquivo(s) e(sao) acima do tamanho pre-determinado.") ;
			}
		} else {
			print ("O(s) arquivo(s) escolhido(s) nao e(sao) permitido(s).") ;
		}
	}
	
	/**
	 * Verifica se o arquivo e do tamanho determinado pelo programador.
	 *
	 * @param int $_max_size        	
	 * @return Bool
	 */
	private function size($_max_size) {
		$_max_size = self::convertMbToBt ( $_max_size );
		
		if ($this->isFile ()) {
			if (self::isArray ( $this->file ["size"] )) {
				$count = count ( $this->file ["size"] );
				$counter = 0;
				
				foreach ( $this->file ["size"] as $newSize ) {
					($newSize <= $_max_size) ? $counter ++ : $counter --;
				}
				
				return ($counter == $count) ? true : false;
			} else {
				return ($this->file ["size"] <= $_max_size) ? true : false;
			}
		}
	}
	
	/**
	 * Verifica se o arquivo enviado � de uma das extens�es permitidas.
	 *
	 * @return Bool
	 */
	private function isFile() {
		if (self::isArray ( $this->extension )) {
			$extensions = implode ( "|", $this->extension );
			
			$_file_test = self::isArrayEmpty ( $this->file ["name"] );
			
			if (self::isArray ( $_file_test )) {
				$count = count ( $_file_test );
				$counter = 0;
				
				foreach ( $_file_test as $values ) {
					(preg_match ( "/.+\.({$extensions})/", $values )) ? $counter ++ : $counter --;
				}
				
				return ($count == $counter) ? true : false;
			} else {
				return (preg_match ( "/.+\.({$extensions})/", $_file_test )) ? true : false;
			}
		}
	}
	
	/**
	 * Verifica se existe algum campo vazio.
	 *
	 * @param
	 *        	s Array $_array array de uma key do $_FILES
	 * @return Array
	 */
	private function isArrayEmpty($_array) {
		if (is_array ( $_array )) {
			$_array_search = array_search ( "", $_array );
			
			if (is_numeric ( $_array_search ))
				unset ( $_array [$_array_search] );
		}
		
		return $_array;
	}
	
	/**
	 * Verifica se � array.
	 *
	 * @param
	 *        	s Array $_array array de uma key do $_FILES
	 * @return Bool
	 */
	private function isArray($_array) {
		return (is_array ( $_array )) ? true : false;
	}
	
	/**
	 * Transforma o valor em MB para Byte
	 *
	 * @param
	 *        	s int $_size valor em MB do tamanho m�ximo
	 * @return int
	 */
	private function convertMbToBt($_size) {
		return $_size * pow ( 2, 1024 );
	}
}
?>