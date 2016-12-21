
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL; ?>user">Listar User</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>user/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
<input type="hidden" name="idUser" value="<?=$this->obj->getId_user()?>" />

<div class="form-group">
	<label for="name" class="col-md-2 col-sm-2 col-xs-12 control-label">Nome</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="name" id="name"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getName()?>" />
	</div>
</div>

<div class="form-group">
	<label for="login" class="col-md-2 col-sm-2 col-xs-12 control-label">Login</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="login" class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getLogin()?>" />
	</div>
</div>

<div class="form-group">
	<label for="password" class="col-md-2 col-sm-2 col-xs-12 control-label">Password</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="password" id="password"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getPassword()?>" />
	</div>
</div>

<div class="form-group">
	<label for="email" class="col-md-2 col-sm-2 col-xs-12 control-label">E-mail</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="email" id="email"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getEmail()?>" />
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>user" class="btn btn-primary">Cancelar</a>
	</div>
</div>


</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->
