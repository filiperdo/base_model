
<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
	<div class="x_title">
		<h2 class="page-header"><?php echo $this->title; ?></h2>
		<div class="clearfix"></div>
		<ol class="breadcrumb">
			<li><a href="<?php echo URL; ?>">Home</a></li>
			<li><a href="<?php echo URL; ?>stock">Listar Stock</a></li>
			<li class="active"><?php echo $this->title; ?></li>
		</ol>
	</div>

<form id="form1" name="form1" method="post" action="<?php echo URL;?>stock/<?php echo $this->action;?>/" class="form-horizontal">

<div class="row">

<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
<input type="hidden" name="idStock" value="<?=$this->obj->getId_stock()?>" />

<div class="form-group">
	<label for="amount" class="col-md-2 col-sm-2 col-xs-12 control-label">Amount</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="amount" id="amount"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getAmount()?>" />
	</div>
</div>

<div class="form-group">
	<label for="min" class="col-md-2 col-sm-2 col-xs-12 control-label">Min</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="min" id="min"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getMin()?>" />
	</div>
</div>

<div class="form-group">
	<label for="max" class="col-md-2 col-sm-2 col-xs-12 control-label">Max</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="max" id="max"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getMax()?>" />
	</div>
</div>

<div class="form-group">
	<label for="date" class="col-md-2 col-sm-2 col-xs-12 control-label">Date</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
		<input type="text" name="date" id="date"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getDate()?>" />
	</div>
</div>

<div class="form-group">
	<label for="id_product" class="col-md-2 col-sm-2 col-xs-12 control-label">Id_product</label> 
	<div class="col-md-9 col-sm-9 col-xs-12"> 
	<select name="id_product" id="id_product"  class="form-control col-md-7 col-xs-12" required="required">
		<option value=""></option>
	</select>
	</div>
</div>

<div class="form-group">
	<div class="col-sm-10  col-sm-offset-2">
		<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
		<a href="<?php echo URL; ?>stock" class="btn btn-primary">Cancelar</a>
	</div>
</div>


</div>
</div>

</form>
</div>
</div>
</div>
<!-- /.row -->