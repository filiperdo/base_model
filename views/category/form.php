
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL; ?>category">Listar Categoria</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>category/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6">
<input type="hidden" name="idCategory" value="<?=$this->obj->getId_category()?>" />

<div class="form-group">
	<label for="name" class="col-sm-2 control-label">Nome</label>
	<div class="col-sm-10">
		<input type="text" name="name" id="name"  class="form-control" required="required" value="<?=$this->obj->getName()?>" />
	</div>
</div>

<div class="form-group">
	<label for="id_typecategory" class="col-sm-2 control-label">Tipo</label>
	<div class="col-sm-10">
	<select name="id_typecategory" id="id_typecategory"  class="form-control" required="required">
		<?php foreach( $this->listTypeCategory as $type ) { ?>
		<option value="<?php echo $type->getId_typecategory();?>"><?php echo $type->getName();?></option>
		<?php } ?>
	</select>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>category" class="btn btn-primary">Cancelar</a>
	</div>
</div>


</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->
