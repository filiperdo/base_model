<?php

include_once 'bancodedados.class.php';

class Excel
{
    private $nomeArquivo;
    private $nomeCampo; // Array

    public function __construct()
    {
        $this->nomeCampo = Array();
    }

    public function spreadsheet( $sql, $nomeArquivo )
    {
        $this->nomeArquivo = $nomeArquivo;

        $clsBd = new BancodeDados();
        $result = $clsBd->executarSQL( $sql );

        $colunas = $result->fetch_fields();
        
        //var_dump( $colunas );
        
        //$rows = mysql_num_rows($result);

        header("Expires: Mon, 1 Apr 1974 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Pragma: no-cache");
        header("Content-type: application/octet-stream; name = alunos" . ".xls");
        header("Content-Disposition: attachment; filename = " . $this->nomeArquivo . ".xls");
        header("Content-Description: MID Gera excel");

        $spreadsheet = '';
		
        // Monta o cabeçalho
        foreach ( $colunas as $coluna )
        {
            $spreadsheet .= $coluna->name . "\t";
            $this->nomeCampo[] = $coluna->name;
        }

        $spreadsheet .= "\n";

        while ($row = $result->fetch_array() )
        {
            foreach ( $this->nomeCampo as $nome )
            {
                $spreadsheet .= $row[$nome] . "\t";
            }

            $spreadsheet .= "\n";
        }

        print $spreadsheet;
    }

}

?>
