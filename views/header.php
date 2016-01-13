<?php Session::init(); ?>
<?php 

if (Session::get('loggedIn') == false)
{
	$menu = array(
		'index'			=> "Dashboard",
		'help'			=> "Escolas",
	);
	
	$icones = array(
		'index' 	=> 'glyphicon glyphicon-globe',
		'help'		=> "glyphicon glyphicon-home",
	);
}
else if( Session::get('loggedIn') == true )
{
	$menu = array(
		'dashboard'			=> "Dashboard",
		'note'				=> "Notes",
		'user'				=> "Users",
	);
	
	$icones = array(
		'dashboard' 		=> 'glyphicon glyphicon-globe',
		'note'				=> "glyphicon glyphicon-home",
		'user'				=> "glyphicon glyphicon-scissors",
	);
}

function compararPaginas( $pagina1, $pagina2 )
{
	$valor1 = explode("-", $pagina1);
	$valor2 = explode("-", $pagina2);

	if( $valor1[0] == $valor2[0] )
		return true;
	else
		return false;
}

?>    
    
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="iso-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href='<?php echo URL; ?>public/img/ico.ico' rel='shortcut icon' type='image/x-icon'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?=(isset($this->title)) ? $this->title : 'MVC'; ?></title>

    <!-- jQuery -->
    <script src="<?php echo URL; ?>public/js/jquery.min.js"></script>
    
    <?php 
    if (isset($this->js)) 
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }
    ?>
    
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo URL; ?>public/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo URL; ?>public/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo URL; ?>public/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo URL; ?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<!-- STYLE default -->
    <link href="<?php echo URL; ?>public/css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Nome</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo 'nome'; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Editar perfil</a>
                        </li>
                        <!-- <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>-->
                        
                        <li class="divider"></li>
                        <li>
                            <a href="../controller/login-controle.php?logout=1"><i class="fa fa-fw fa-power-off"></i> Sair</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                	
	                <?php foreach( $menu as $key => $item ) { ?>
	        
			        <li <?php if( compararPaginas( $this->title, $key ) ) { echo ' class="active"'; }?>>
			        	<a href="<?php echo URL . $key; ?>">
			        		<i class="<?php echo $icones[$key]?>"></i> <?php echo $item; ?> 
			        	</a>
			        </li>
			        
			        <?php } ?>
                
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">