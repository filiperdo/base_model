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
		$foto_padrao = URL . 'public/img/avatar-fat.jpg';
		
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
		$str = strtolower(trim($str));
		$str = preg_replace('/[^a-z0-9-]/', '-', $str);
		$str = preg_replace('/-+/', "-", $str);
		return $str;
	}

}

?>
