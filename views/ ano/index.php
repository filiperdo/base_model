<!-- Page Heading -->
<div class="row">
<div class="col-lg-12">
<h1 class="page-header"><?php echo $this->title; ?></h1>
<div class="row">
<div class="col-lg-6 col-md-6">
<ol class="breadcrumb">
<li><a href="index.php">Home</a></li>
<li class="active"><?php echo $this->title; ?></li>
</ol></div>
<div class="col-lg-4 col-md-3">
<div class="form-group input-group">
<input type="text" class="form-control" id="busca">
<span class="input-group-btn">
<button class="btn btn-default" type="button">
<i class="glyphicon glyphicon-search"></i>
</button></span></div></div>
<div class="col-lg-2 col-md-2">
<a href="<?php echo URL;?>ano/form" class="btn btn-success">Cadastrar <?php echo $this->title; ?></a>
</div>
</div>
</div>
</div>
<!-- /.row -->

<?php if (isset($_GET["st"])) { $objAlert = new Alerta($_GET["st"]); } ?>

<table class="table-striped sortable">
	<thead>
	<tr>
		<th>Id_ano </th>
		<th>Descricao </th>
		<th></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach( $this->listarAno( $objPaginacao ) as $ano ) { ?>
	<tr>
 		<td><?php echo $ano->getId_ano(); ?></td>
		<td><?php echo $ano->getDescricao(); ?></td>
		<td align="right">
			<a href="<?php echo URL;?>ano/form/<?php echo $ano->getId_ano();?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>
			<a href="<?php echo URL;?>ano/delete/<?php echo $ano->getId_ano();?>" class="delete btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>
		</td>
		</tr>
	<?php } ?>
	</tbody>
</table>
</div><!-- .row -->


<script>
$(function() {
	$(".delete").click(function(e) {
	var c = confirm("Deseja realmente deletar este registro?");
	if (c == false) return false;
	}); 
 });
</script>