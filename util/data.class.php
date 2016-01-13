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

}

?>