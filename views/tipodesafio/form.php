<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header"><?php echo $this->title; ?></h1>
			
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL;?>tipodesafio">Tipodesafio</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
			
	</div>
		
</div>
<!-- /.row -->

 
<form id="form1" name="form1" method="post" action="<?php echo URL;?>tipodesafio/<?php echo $this->action;?>/">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6">

<input type="hidden" name="idTipodesafio" value="<?=$this->obj->getId_tipodesafio()?>" />

<div class="form-group">
	<label for="descricao">Descricao </label> 
	<input type="text" name="descricao" id="descricao"  class="form-control" required="required" value="<?=$this->obj->getDescricao()?>" />
</div>

<div class="form-group">
	<label for="file">File</label> 
	<input type="text" name="file" id="file"  class="form-control" required="required" value="<?=$this->obj->getFile()?>" />
</div>

<div class="form-group">
	<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
	<a href="<?php echo URL;?>tipodesafio" class="btn btn-info">Cancelar</a><!-- Mudar o link de volta a lista -->
</div>

</div>
</div>


</form>