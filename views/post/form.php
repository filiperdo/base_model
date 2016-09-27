
<!-- Styles -->
<link href="<?php echo URL?>util/jqueryfiler/css/jquery.filer.css" rel="stylesheet">
<link href="<?php echo URL?>util/jqueryfiler/css/themes/jquery.filer-dragdropbox-theme.css" rel="stylesheet">

<!-- Jvascript -->
<script src="<?php echo URL?>util/jqueryfiler/js/jquery.filer.min.js" type="text/javascript"></script>
<script src="<?php echo URL?>util/jqueryfiler/js/custom.js" type="text/javascript"></script>

<!-- Page Heading -->
<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2 class="page-header"><?php echo $this->title; ?></h2>
				<div class="clearfix"></div>
				<ol class="breadcrumb">
					<li><a href="<?php echo URL; ?>">Home</a></li>
					<li><a href="<?php echo URL; ?>post">Listar Post</a></li>
					<li class="active"><?php echo $this->title; ?></li>
				</ol>
			</div>
			
			<div class="col-md-8 col-sm-8 col-lg-8 col-xs-12">
				<form id="form1" name="form1" method="post" action="<?php echo URL;?>post/<?php echo $this->action;?>" class="form-horizontal" enctype="multipart/form-data">
				<input type="hidden" name="idPost" value="<?=$this->obj->getId_post()?>" />
				<input type="hidden" name="path" value="<?=$this->path?>" />
				
				<div class="form-group">
					<label for="title" class="col-md-2 col-sm-2 col-xs-12 control-label">Title</label> 
					<div class="col-md-10 col-sm-10 col-xs-12"> 
						<input type="text" name="title" id="title"  class="form-control col-md-7 col-xs-12" required="required" value="<?=$this->obj->getTitle()?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label for="status" class="col-md-2 col-sm-2 col-xs-12 control-label">Status</label> 
					<div class="col-sm-3 col-sm-3 col-xs-12"> 
						<select name="status" class="form-control">
							<option value="DRAFT" <?php if( $this->obj->getStatus() == 'DRAFT' ){?>selected="selected"<?php }?>>Rascunho</option>
							<option value="PUBLISHED" <?php if( $this->obj->getStatus() == 'PUBLISHED' ){?>selected="selected"<?php }?>>Publicado</option>
						</select>
					</div>
					
					<div class="col-sm-7 col-sm-7 col-xs-12"> 
						
						<div class="input-group">
						  <span class="input-group-addon" id="basic-addon1"><i class="glyphicon glyphicon-picture"></i></span>
						  <input type="text" name="mainpicture" id="mainpicture" placeholder="Link da imagem de capa" class="form-control" value="<?php echo $this->obj->getMainpicture(); ?>" />
						</div>
					
					</div>
				</div>
				
				<div class="form-group">
					<label for="content" class="col-sm-2 control-label">Content</label> 
					<div class="col-sm-10"> 
						<textarea class="form-control" id="content" name="content" rows="13"><?=$this->obj->getContent()?></textarea>
					</div>
				</div>
				
				<div class="checkbox">
					<label class="col-sm-2 control-label">Categorias</label> 
					<div class="col-sm-10 ">
						<?php foreach( $this->listCategory as $category ) { ?>
						<label style="margin: 10px 20px 20px 0">
							<input type="checkbox" value="<?php echo $category->getId_category(); ?>" name="categoria[]" <?php if( in_array($category->getId_category(), $this->array_category ) ){?>checked="checked"<?php } ?>> 
							<?php echo $category->getName(); ?>
						</label>
						<?php } ?>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-10  col-sm-offset-2">
						<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />
						<a href="<?php echo URL; ?>post" class="btn btn-info">Cancelar</a>
					</div>
				</div>
				
				</form>
			</div><!-- .col-md-8 -->
			
			<div class="col-md-4 col-sm-4 col-lg-4 col-xs-12">
				
				<!-- debug <form name="form5" action="http://localhost/khas/post/wideimage_ajax/" method="post" enctype="multipart/form-data" >
					<input type="file" name="files[]"  multiple="multiple" >
					<input type="submit">
				</form> -->
				
				<input type="hidden" name="action_post" id="action_post" value="<?php echo $this->method_upload; ?>">
				<input type="file" name="files[]" id="filer_input2" multiple="multiple">
			
				<div id="output-files">
				<ul class="jFiler-items-list jFiler-items-grid" style="padding: 0">
					<?php if( $this->path != '' ) { ?>
					<?php foreach ( Data::getImgPost('post', $this->path, true ) as $img ) { ?>
					<li class="jFiler-item">
						<div class="jFiler-item-container">
							<div class="jFiler-item-inner">
								<div class="jFiler-item-thumb"><img alt="" src="<?=URL.$img?>" ></div>
								<div class="jFiler-item-assets jFiler-row">
									<ul class="list-inline pull-left">
										<li>
											<?php $link_img = str_replace('/thumb/', '/', $img);?>
											<button class="bt-copy btn btn-primary btn-xs" data-clipboard-action="copy" data-clipboard-text="<?='../../'.$link_img?>"><i class="glyphicon glyphicon-link"></i> Copy</button>
										</li>
									</ul>
									<ul class="list-inline pull-right">
										<li><a href="<?php echo URL?>post/delete_img/<?php echo base64_encode($img);?>" class="icon-jfi-trash jFiler-item-trash-action"></a></li>
									</ul>
								</div>
							</div>
						</div>
					</li>
					<?php } // end foreach?>
					<?php } // end if ?>
				</ul>
				</div>
			
			</div><!-- col-md-4 -->
				
		</div>
	
	</div>
</div>

<!-- /.row -->

<script>

	var clipboard = new Clipboard('.bt-copy');

    clipboard.on('success', function(e) {
        console.log(e);
    });

    clipboard.on('error', function(e) {
        console.log(e);
    });
	
</script>

<script src='<?php echo URL?>util/tinymce/tinymce.min.js'></script>
<script>

  tinymce.init({
	  selector: '#content',
	  theme: 'modern',
	  menubar:false,
	  image_prepend_url: "<?php echo URL?>",
	  plugins: [
	    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	    'searchreplace wordcount visualblocks visualchars code fullscreen',
	    'insertdatetime media nonbreaking save table contextmenu directionality',
	    'emoticons template paste textcolor colorpicker textpattern imagetools'
	  ],
	  toolbar1: ' bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor source code',
  });

</script>