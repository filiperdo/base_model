
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL; ?>newsletter">Listar Newsletter</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>newsletter/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6">
<input type="hidden" name="idNewsletter" value="<?=$this->obj->getId_newsletter()?>" />

<div class="form-group">
	<label for="email" class="col-sm-2 control-label">Email</label> 
	<div class="col-sm-10"> 
		<input type="text" name="email" id="email"  class="form-control" required="required" value="<?=$this->obj->getEmail()?>" />
	</div>
</div>

<div class="form-group">
	<label for="data" class="col-sm-2 control-label">Data</label> 
	<div class="col-sm-10"> 
		<input type="text" name="data" id="data"  class="form-control" required="required" value="<?=$this->obj->getData()?>" />
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>newsletter" class="btn btn-primary">Cancelar</a>
	</div>
</div>


</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->