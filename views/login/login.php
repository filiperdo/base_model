
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">
    <title><?php echo SYSTEM_NAME; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Nepali">

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <script src="<?php echo URL; ?>public/js/jquery.min.js"></script>
    <link href="<?php echo URL; ?>public/css/bootstrap.css" rel="stylesheet">
    <script src="<?php echo URL; ?>public/js/bootstrap.min.js"></script>
	
    <script src="<?php echo URL; ?>public/js/jquery.validate.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.js"></script>
    <![endif]-->
    
    <script>
		$().ready(function() {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#formLogin").validate({
				errorContainer: container,
				errorLabelContainer: $("ol", container),
				wrapper: 'li'
			});
		});
	</script>
  </head>
  <body>
    <div class="container">
	  
      <form action="<?php echo URL?>login/run" class="form-signin" method="post" id="formLogin">
      <input type="hidden" name="action" value="autenticarUsuario">
        <h2 class="form-signin-heading" align="center"><!-- <img src="../img/img_logo.png" width="216" height="89" alt=" "> --></h2>
        
		<?php if (isset($_GET['st'])) { $objAlerta = new Alerta($_GET['st']); } ?> 
		
        <input type="text" name="login" class="form-control input-block-level" placeholder="Login" required>
        <input type="password" name="password" class="form-control input-block-level" placeholder="Senha" required>
        <button class="btn btn-large btn-success" type="submit">Entrar</button>
      </form>
    </div> <!-- /container -->
  </body>
</html>