<?php


$objAno = new Ano();

if( isset( $_GET["idAno"] ) )
{
	$objAno->obterAno( $_GET["idAno"] );
}

?>
<form id="form1" name="form1" method="post" action="<?php echo URL;?>ano/create/">

<div class="container-fluid">

<div class="col-md-6 col-sm-6 col-lg-6">

<div class="row">

<h2 class="sub-header"> <?php echo $this->title; ?> </h2>
<input type="hidden" name="idAno" value="<?=$objAno->getId_ano()?>" />

<div class="form-group">
	<label for="ano" class="control-label col-xs-3">id_ano</label>

<div class="col-xs-8">
	<select name="ano" id="ano" class="form-control" required="required">
	<option value="" disabled="disabled" selected="selected">Selecione a ano</option>
	<?php foreach( $objAno->listarAno() as $ano ) { ?>
		<option value="<?=$ano->getId_ano()?>" <?php if( $ano->getId_ano() == $objAno->getId_ano() ){ ?>selected="selected"<?php } ?>>
		<?php echo $ano->getId_ano()?></option>
	<?php } ?>
	</select>
</div>
</div>

<div class="form-group">
	<label class="control-label col-xs-3" for="descricao">Descricao</label> 
	<div class="col-xs-8">
		<input type="text" name="descricao" id="descricao"  class="form-control" required="required" value="<?=$objAno->getDescricao()?>" />
	</div>
</div>

<div class="form-group">

<div class="col-xs-offset-3 col-xs-9">
	<a href="index.php?p=ano-lista" class="btn btn-info">Cancelar</a>
	<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
</div>
</div>


</div>
</div>
</div>

</form>