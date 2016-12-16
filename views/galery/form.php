
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL; ?>galery">Listar Galery</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>galery/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
<input type="hidden" name="idGalery" value="<?=$this->obj->getId_galery()?>" />

<div class="form-group">
	<label for="name" class="col-md-2 col-sm-2 col-xs-12 control-label">Name</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="name" id="name"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getName()?>" />
	</div>
</div>

<div class="form-group">
	<label for="slug" class="col-md-2 col-sm-2 col-xs-12 control-label">Slug</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="slug" id="slug"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getSlug()?>" />
	</div>
</div>

<div class="form-group">
	<label for="path" class="col-md-2 col-sm-2 col-xs-12 control-label">Path</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="path" id="path"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getPath()?>" />
	</div>
</div>

<div class="form-group">
	<label for="mainpicture" class="col-md-2 col-sm-2 col-xs-12 control-label">Mainpicture</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="mainpicture" id="mainpicture"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getMainpicture()?>" />
	</div>
</div>

<div class="form-group">
	<label for="date" class="col-md-2 col-sm-2 col-xs-12 control-label">Date</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="date" id="date"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getDate()?>" />
	</div>
</div>

<div class="form-group">
	<label for="id_user" class="col-md-2 col-sm-2 col-xs-12 control-label">Id_user</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
	<select name="id_user" id="id_user"  class="form-control col-md-7 col-xs-12" required="required">
		<option value=""></option>
	</select>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>galery" class="btn btn-primary">Cancelar</a>
	</div>
</div>


</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->