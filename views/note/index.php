<!-- Page Heading -->
<div class="row">
	<div class="col-lg-12">

		<h1 class="page-header"><?php echo $this->title; ?></h1>

		<div class="row">
			<div class="col-lg-6 col-md-6">
				<ol class="breadcrumb">
					<li><a href="index.php">Home</a></li>
					<li class="active"><?php echo $this->title; ?></li>
				</ol>
			</div>

			<div class="col-lg-4 col-md-3">
				<div class="form-group input-group">
					<input type="text" class="form-control" id="busca"> 
					<span class="input-group-btn">
						<button class="btn btn-default" type="button">
							<i class="glyphicon glyphicon-search"></i>
						</button>
					</span>
				</div>
			</div>
			
			<div class="col-lg-2 col-md-2">
				<a href="<?php echo URL;?>note/form" class="btn btn-success">Cadastrar Note</a>
			</div>

		</div>
	</div>

</div>
<!-- /.row -->

<table class="table table-striped sortable">
<?php
    foreach($this->noteList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['title'] . '</td>';
        echo '<td>' . $value['date_added'] . '</td>';
        echo '<td align="right">';
        echo '<a href="'. URL . 'note/edit/' . $value['noteid'].'" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a> ';
        echo '<a href="'. URL . 'note/delete/' . $value['noteid'].'" class="delete btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>';
        echo '</td></tr>';
    }
?>
</table>

<script>
$(function() {
    
    $('.delete').click(function(e) {
        var c = confirm("Are you sure you want to delete?");
        if (c == false) return false;
    });
    
});
</script>