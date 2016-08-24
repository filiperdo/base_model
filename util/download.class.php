<?php

class Download
{
	public function __construct( $file, $newName )
	{
		// Verifica se o arquivo existe
		if (!file_exists( $file )) {
			return false;
			exit();
		}
		
		// Configura os headers que serao enviados para o browser
		header('Content-Description: File Transfer');
		header('Content-Disposition: attachment; filename="'. $newName .'"');
		header('Content-Type: application/octet-stream');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: ' . filesize( $file ));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Expires: 0');
		
		// Envia o arquivo para o cliente
		readfile( $file );
	}
}

