<?php

class Data
{
    /**
     * Implementar
     * date( 'd/m/Y', strtotime( $this->dataRegistro ) )
     */
    
	static public function formataData($data)
	{
		if (!empty($data))
		{
			return implode('/', array_reverse(explode('-', $data)));
		}
	}
	
	static public function formatDateShort( $data )
	{
		$array_meses = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');
		
		if (!empty($data))
		{
			$d = explode(' ', $data);
			
			$data = array_reverse( explode('-', $d[0]) );
			
			return $data[0] . ' de ' . $array_meses[ (int)$data[1] ] . ', ' . $data[2];
		}
		
	}
	
	static public function formataDataHora($data)
	{
		if (!empty($data))
		{
			$d = explode(' ', $data);
			return implode('/', array_reverse(explode('-', $d[0]))) . ' ' . $d[1];
		}
	}
	
	static public function formataDataRetiraHora($data)
	{
		if (!empty($data))
		{
			$d = explode(' ', $data);
			$data_hora = implode('/', array_reverse(explode('-', $d[0]))) . ' ' . $d[1];
			return substr($data_hora,0,10);
		}
	}
	
	static public function formataDataBD($data)
	{
		if (!empty($data))
		{
			return implode('-', array_reverse(explode('/', $data)));
		}
	}
	
	static public function formataMoeda($valor)
	{
		if (!empty($valor))
			return number_format($valor, 2, ',', '.');
	}
	
	static public function formataMoedaBD($valor)
	{
		$valor = str_replace('.', '', $valor);
		$valor = str_replace(',', '.', $valor);
		return $valor;
	}
	
	static public function formataTel($tel)
	{
		$retorno = '';
		if ($tel != 0 && !empty($tel)) {
			$retorno = '('.substr($tel, 0, 2).')'.substr($tel, 2, 4).'-'.substr($tel, -4);
		}
		return $retorno;
	}
	
	static public function formataCep($cep)
	{
		if (!empty($cep))
		{
			return substr($cep, 0, 5) . '-' . substr($cep, -3);
		}
	}
	
	static public function formataCepBD($cep)
	{
		if( !empty($cep) )
		{
			return str_replace('-','', $cep);
		}
	}
	
	static public function gerarSenha($length = 6)
	{
		$array = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U",1,2,3,4,5,6,7,8,9,0);
		shuffle( $array );
		$senha = array_slice( $array, 0, $length );
		$senha = implode( "", $senha );
	
		return $senha; 
	}
	
	/**
	 * Obtem a imagem do perfil do usuario
	 * Em formatos JPG ou PNG
	 * @param unknown $id
	 */
	static public function getPhotoUser( $id )
	{
		$pasta = 'public/img/user/' . $id . '/';
		$foto_padrao = URL . 'public/img/user.png';
		
		$allowedExts = array(".gif", ".jpeg", ".jpg", ".png");
		
		if ( is_dir( $pasta ) )
		{
			$diretorio = dir($pasta);
			$retorno = false;
			
			while(($arquivo = $diretorio->read()) !== false)
			{
				$tipo = substr($arquivo,-4);
				if(in_array($tipo, $allowedExts)) // if( $tipo == ".jpg" || $tipo == ".png" )
				{
					return URL . $pasta . $arquivo ;
					$retorno = true;
				}
			}
			$diretorio->close();
				
			if( $retorno == false )
				return $foto_padrao;
		}
		else {
			return $foto_padrao;
		}
	}
	
	/**
	 * Obtem as imagens dos post ou projetos para exibir na home
	 * @param unknown $type
	 * @param unknown $id
	 * @return unknown[]
	 */
	static public function getImgPost( $type, $path, $thumb = NULL )
	{
		$array_img = array();
		
		if( $thumb )
		{
			foreach( glob('public/img/'. $type .'/'. $path .'/thumb/*.*' ) as $key => $imagem )
			{
				$array_img[] = $imagem;
			}
		}
		else {
			foreach( glob('public/img/'. $type .'/'. $path .'/*.*' ) as $key => $imagem )
			{
				$array_img[] = $imagem;
			}
		}
		
		return $array_img;
	}

	static function timeAgo( $timestamp )
	{
		require_once 'util/time-ago/westsworld.datetime.class.php';
		require_once 'util/time-ago/timeago.inc.php';
		
		$timestamp = str_replace('-', '/', $timestamp);
		
		$timeAgo = new TimeAgo( NULL, 'pt-BR' );
		return $timeAgo->inWords( $timestamp );
	}
	
	/**
	 * Metodo para gerar um slug de qualquer string
	 * @param unknown $str
	 */
	static function formatSlug($str)
	{
		// assume $str esteja em UTF-8
		$map = array(
		    'á' => 'a',
		    'à' => 'a',
		    'ã' => 'a',
		    'â' => 'a',
		    'é' => 'e',
		    'ê' => 'e',
		    'í' => 'i',
		    'ó' => 'o',
		    'ô' => 'o',
		    'õ' => 'o',
		    'ú' => 'u',
		    'ü' => 'u',
		    'ç' => 'c',
		    'Á' => 'A',
		    'À' => 'A',
		    'Ã' => 'A',
		    'Â' => 'A',
		    'É' => 'E',
		    'Ê' => 'E',
		    'Í' => 'I',
		    'Ó' => 'O',
		    'Ô' => 'O',
		    'Õ' => 'O',
		    'Ú' => 'U',
		    'Ü' => 'U',
		    'Ç' => 'C'
		);
		 
		$str = strtr($str, $map);

		$str = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $str ) );
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;

	}
	
	
	static function formatSlug_old($string, $slug = true)
	{
		$string = strtolower($string);
		
		// Código ASCII das vogais
		$ascii['a'] = range(224, 230);
		$ascii['e'] = range(232, 235);
		$ascii['i'] = range(236, 239);
		$ascii['o'] = array_merge(range(242, 246), array(240, 248));
		
		$ascii['u'] = range(249, 252);
		// Código ASCII dos outros caracteres
		$ascii['b'] = array(223);
		$ascii['c'] = array(231);
		$ascii['d'] = array(208);
		$ascii['n'] = array(241);
		$ascii['y'] = array(253, 255);
		
		foreach ($ascii as $key=>$item) {
			$acentos = '';
			foreach ($item AS $codigo) $acentos .= chr($codigo);
			$troca[$key] = '/['.$acentos.']/i';
		}
		
		$string = preg_replace(array_values($troca), array_keys($troca), $string);
		
		// Slug?
		if ($slug) {
			// Troca tudo que não for letra ou número por um caractere ($slug)
			$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
			// Tira os caracteres ($slug) repetidos
			$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
			$string = trim($string, $slug);
		}
		return $string;
	}

}

?>
