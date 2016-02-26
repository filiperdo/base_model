<?php   

if( isset( $_GET['cep'] ) && $_GET['cep'] != '' )
{
	$cepTemp = $_GET['cep'];
	
	$resultado = @file_get_contents('http://cep.republicavirtual.com.br/web_cep.php?cep=' . $_GET['cep'] . '&formato=json');  

	ini_set('default_charset','utf-8');

	echo $resultado;	
}
  
?> 
<script type="text/javascript">

$('#cep').blur(function(){
		
	$('#retorno').load( "../controller/cep_endereco.php?cep="+$(this).val(), function(data){

		var retorno = JSON.parse( data );
		
		$( '#estado' ).val( retorno.uf );
		$( '#cidade' ).val( retorno.cidade );
		$( '#bairro' ).val( retorno.bairro );
		$( '#logradouro' ).val( retorno.tipo_logradouro + ' ' + retorno.logradouro );
		
	});
	
});

</script>