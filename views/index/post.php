<div class="hh">

	<ol class="breadcrumb bread-border">
	  <li><a href="<?php echo URL?>">Home</a></li>
	  <li><a href="<?php echo URL?>blog">Blog</a></li>
	  <li><span class="text-uppercase"><?php echo $this->obj->getTitle();?></span></li>
	</ol>

	<ul class="ca qo anx" id="indexTest">
		<li class="qf b aml">
	        <div class="qw dj " style="padding-top: 0">
	        	<h3 class="text-uppercase"><?php echo $this->obj->getTitle(); ?></h3>
	        	<p class="alu">
		        	<small><?=Data::formatDateShort($this->obj->getDate())?>
		        	<?php if( !empty($this->obj->getAuthor()) ){ echo ' | por ' . $this->obj->getAuthor(); } ?>
		        	</small>
		        	</p>

				<div class="post-content text-justify"><p class=""><?=$this->obj->getContent()?></p></div>

				<div class="text-left"><small>Fonte: <a href="<?php echo $this->obj->getSource(); ?>" target="_blank"><?php echo substr($this->obj->getSource(), 0,40).'...'; ?></a></small></div>
			</div>
		</li>

		<!-- <li class="qf b aml">
			<div class="any" data-grid="images">
            <?php foreach( glob('public/img/post/'. $this->obj->getId_post() .'/*.jpg') as $imagem ){ ?>
            <?php list($width, $height, $type, $attr) = getimagesize( $imagem ); ?>
              <div style="display: none">
                <img data-action="zoom" data-width="<?php echo $width; ?>" data-height="<?php echo $height; ?>" src="<?php echo URL . $imagem; ?>">
              </div>
			<?php } ?>
            </div>
		</li> -->

		<li class="qf b aml">

		<h5 class="page-header">Comentários (<?php echo $this->objComment->getTotalComment( 'post', $this->obj->getId_post() ); ?>)</h5>

		<ul class="qo alm">
		<?php if( Session::get('loggedIn' ) ) { ?>
            <li class="qf">
                <a class="qj" href="#">
                  <img class="qh cu" src="<?php echo Data::getPhotoUser( Session::get('userid') ); ?>">
                </a>
                <div class="qg">
                  <strong><?php echo Session::get('user_login'); ?>: </strong>

                  <input type="hidden" id="comment_type-<?php echo $this->obj->getId_post() ?>"  name="comment_type" value="post">

                  <div class="row">
					<div class="col-md-9"><input type="text" class="form-control" name="content" required="required" id="content-<?php echo $this->obj->getId_post() ?>" placeholder="Escrava um comentário" style="margin-bottom: 5px"></div>

					<div class="col-md-3"><a class="cg ts fx bt-sub-form" id="<?php echo $this->obj->getId_post() ?>"><span class="h aah"></span> Publicar</a></div>
				  </div>
                </div>
            </li>
            <?php } ?>

            <li class="qf" id="result-<?php echo $this->obj->getId_post(); ?>" style="display: none"><img alt="Carregando..." src="<?php echo URL?>public/img/loader.gif"> Carregando...</li>

            <?php foreach( $this->objComment->listCommentByType( 'post', $this->obj->getId_post() ) as $comment ) { ?>
              <li class="qf">
                <a class="qj" href="#">
                  <img class="qh cu" src="<?php echo Data::getPhotoUser( $comment->getUser()->getId_user() ); ?>">
                </a>
                <div class="qg">
                  <strong><a href="<?php echo URL . 'user/dashboard/'. $comment->getUser()->getLogin()?>"><?php echo $comment->getUser()->getLogin()?>: </a></strong>
                  <?php echo $comment->getContent();?>
                </div>
              </li>
            <?php } ?>
		</ul>
		</li>
	</ul>

</div>

	<div class="gr"><!-- gn Coluna direita -->

		<div class="qv rc alu">
	        <div class="qw">

	        <h4 class="page-header">Artigos relacionados</h4>

	        <?php foreach( $this->listPostRelated as $post ) { ?>

	          <div class="row" >
	            <div class="col-md-3" style="padding-left: 15px; padding-right: 0">
	            	<div class="" style="background: url(<?php echo URL .'public/img/post/'. $post->getPath() .'/'. $post->getMainpicture(); ?>) center center no-repeat #000; background-size: 210%; overflow: hidden; height:60px"></div>
	            </div>
	            <div class="col-md-9">
	              <a href="<?php echo URL?>blog/post/<?php echo $post->getSlug();?>">
	              	<strong><?php echo strtoupper( $post->getTitle() ); ?> </strong>
	              </a>
	              <p><small><?php echo Data::formatDateShort( $post->getDate() );?> </small></p>
	              <!-- <p><?php echo substr(strip_tags( $post->getContent() ), 0, 80)."..."; ?></p> -->
	            </div>
	          </div>

	          <div class="row" style="border-bottom: 1px solid #eaeaea; margin: 8px 0"></div>
	          <?php } ?>

	        </div>

	      </div>

	      <div class="row" style="margin-bottom: 20px; margin-top: 20px;">
	      	<div class="col-md-12">
	      		<div style="float:left; margin-right:4px" class="fb-share-button" data-href="http://www.robo3d.com.br/blog/post/<?php echo $this->obj->getSlug();?>" data-layout="button_count" data-size="large" data-mobile-iframe="true">
	      		<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.robo3d.com.br/blog/post/<?php echo $this->obj->getSlug();?>%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore cg ts fx"><i class="h aau" style="font-size: 22px"></i> </a>
				</div>
				<a href="#" class="cg ts fx disabled"><i class="h ajo" style="font-size: 22px"></i> </a>
	      		<a href="#" class="cg ts fx disabled"><i class="h adr" style="font-size: 22px"></i> </a>
	      		<a href="#" class="cg ts fx disabled"><i class="h abx" style="font-size: 22px"></i> </a>
	      	</div>
	      </div>

	      <div class="qv rc aok">
	        <div class="qw">
	          <h4 class="page-header">Categorias</h4>
	          <?php foreach( $this->listCategory as $categori ){?>
	          <ul>
	          	<li>
		          <a href="#">
		              <?php echo $categori->getName();?>
		          </a>
	          </li>
	          </ul>
	          <?php } ?>

	        </div>
	      </div>

    </div><!-- .gn Coluna direita -->


<script>

	$(function () {
	  $('.ttp').tooltip();

	  $('.ppv').popover();
	});

</script>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
