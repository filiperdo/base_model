
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home </a></li>
			<li><a href="<?php echo URL; ?>event">Listar Eventos</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>event/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
<input type="hidden" name="idEvent" value="<?=$this->obj->getId_event()?>" />

<div class="form-group">
	<label for="title" class="col-md-2 col-sm-2 col-xs-12 control-label">Título</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="title" id="title"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getTitle()?>" />
	</div>
</div>

<div class="form-group">
	<label for="date" class="control-label col-md-2 col-sm-2 col-xs-12">Data</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="date" id="date"  class="form-control calendary col-md-7 col-xs-12" required="required"  value="<?=Data::formataData($this->obj->getDate())?>" />
	</div>
</div>

<div class="form-group">
	<label for="hour" class="col-md-2 col-sm-2 col-xs-12 control-label">Hora</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<input type="text" name="hour" id="hour"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getHour()?>" />
	</div>
</div>

<div class="form-group">
	<label for="content" class="col-md-2 col-sm-2 col-xs-12 control-label">Descrição</label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<textarea rows="3" name="content" id="content"  class="form-control col-md-7 col-xs-12" required="required" cols=""><?=$this->obj->getContent()?></textarea>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>event" class="btn btn-primary">Cancelar</a>
	</div>
</div>

</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->
