<?php
/**
 * Classe responsavel por gerar todos os arquivos brutos
 * de uma estrutura MVC baseada em um banco de dados
 * 
 * @author Filipe Rodrigues
 * 
 * Data 30/11/2015
 * 
 */
require 'config.php';
class Mvc
{
    private $pathRoot;
    
    private $pdo;
    
    private $host;
    private $user;
    private $password;
    private $conexao;
    private $dbname;
    
    public function __construct()
    {
    	$this->host = DB_HOST;
        $this->user = DB_USER;
        $this->password = DB_PASS;
        $this->dbname = DB_NAME;
        
        try{
        	$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
        }
        catch ( PDOException $e )
        {
        	echo "Erro!: " . $e->getMessage();
        }
        
        $this->pathRoot = '_files/_mvc/';
        
        if( !is_dir( $this->pathRoot ) )
            mkdir( $this->pathRoot, 0777);
        
        $sql = 'show tables from ' . $this->dbname;
        $result = $this->pdo->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        
        //var_dump( $result );
        
        $this->createMenu( $result );
        
        $this->createModel( $result );
        
        $this->createController( $result );
        
        $this->createForms( $result );
        
    	$this->createViews( $result );
    	
    }	
    
    /**
     * Cria o menu
     * @param unknown $result
     */
    private function createMenu( $result )
    {
    	// Configura o diretorio e o nome do arquivo
    	// --------------------
    	$path = $this->pathRoot . 'views/';
    	$fileName = 'menu.php';
    	
    	$string  = '<?php' . "\n\n";
    	$string .= '$menu = array(';
    	
    	foreach ( $result as $rowTabela )
    	{
    		$tableName = $rowTabela['Tables_in_'.$this->dbname];    		
    		
			$string .= "\n\t" . '"'. strtolower( $tableName ) .'"	=> array("label" => "'. ucfirst( $tableName ) .'", "icon" => "glyphicon glyphicon-globe"),';
    		
    	}
    	
    	$string .= $string .= "\n" .');';
    	
    	$this->createFile( $path, $fileName, $string );
    	
    }
    
    /**
     * Cria o diretorio e o arquivo
     * @param unknown $path
     * @param unknown $fileName
     * @param unknown $content
     */
    private function createFile( $path, $fileName, $content )
    {
        if( !is_dir( $path ) )
            mkdir( $path, 0777);
        
        $fp = fopen( $path . $fileName, 'w' );
        $fw = fwrite( $fp, $content );
        fclose( $fp );
        echo '>> ' . $path . $fileName . '<br/>';
    }
    
    /**
     * Cria os diretorios e os arquivos index de cada view
     * @param unknown $result
     */
    private function createViews( $result )
    {
    	foreach ( $result as $rowTabela )
    	{
    		$tableName = $rowTabela['Tables_in_'.$this->dbname];
    		$Query = $this->pdo->prepare("SHOW COLUMNS FROM {$tableName}");
    		$Query->execute();
    		 
    		$colunas = array();
    		 
    		while($e = $Query->fetch(PDO::FETCH_ASSOC))
    		{
    			$colunas[] = $e['Field'];
    		}
    		
            // Configura o diretorio e o nome do arquivo
            // --------------------
            $path = $this->pathRoot . 'views/' . $tableName . '/';
            $fileName = 'index.php';
            
            $string  = '';
            $string .= '<!-- Page Heading -->';
            $string .= "\n" . '<div class="row">';
            $string .= "\n\t" . '<div class="col-lg-12">';
            $string .= "\n\t\t" . '<h1 class="page-header"><?php echo $this->title; ?></h1>';
            $string .= "\n\t\t" . '<div class="row">';
            $string .= "\n\t\t\t" . '<div class="col-lg-6 col-md-6">';
            $string .= "\n\t\t\t\t" . '<ol class="breadcrumb">';
            $string .= "\n\t\t\t\t\t" . '<li><a href="index.php">Home</a></li>';
            $string .= "\n\t\t\t\t\t" . '<li class="active"><a href="<?php echo URL;?>' . $tableName . '"><?php echo $this->title; ?></a></li>';
            $string .= "\n\t\t\t\t" . '</ol>';
            $string .= "\n\t\t\t" . '</div>';
            $string .= "\n\t\t\t" . '<div class="col-lg-4 col-md-3">';
            $string .= "\n\t\t\t" . '<form name="form-search" action="<?php echo URL;?>' . $tableName . '" method="post">';
            $string .= "\n\t\t\t\t" . '<div class="form-group input-group">';
            $string .= "\n\t\t\t\t\t" . '<input type="text" class="form-control" required="required" name="like" id="busca">';
            $string .= "\n\t\t\t\t\t" . '<span class="input-group-btn">';
            $string .= "\n\t\t\t\t\t\t" . '<button class="btn btn-default" type="submit">';
            $string .= "\n\t\t\t\t\t\t\t\t" . '<i class="glyphicon glyphicon-search"></i>';
            $string .= "\n\t\t\t\t\t\t" . '</button>';
            $string .= "\n\t\t\t\t\t" . '</span>';
            $string .= "\n\t\t\t\t" . '</div>';
            $string .= "\n\t\t\t\t" . '</form>';
            $string .= "\n\t\t\t" . '</div>'; 
            $string .= "\n\t\t\t" . '<div class="col-lg-2 col-md-2">';
            $string .= "\n\t\t\t\t" . '<a href="<?php echo URL;?>'.$tableName.'/form" class="btn btn-success">Cadastrar <?php echo $this->title; ?></a>';
            $string .= "\n\t\t\t</div>\n\t\t</div>\n\t</div>\n</div>";
            $string .= "\n" . '<!-- /.row -->';
			$string .= "\n\n" . '<?php if (isset($_GET["st"])) { $objAlert = new Alerta($_GET["st"]); } ?>' . "\n\n";
			
			$string .= '<table class="table table-striped sortable table-condensed">'."\n";
			$string .= "\t" . '<thead>'."\n";
			$string .= "\t" . '<tr>'."\n";
			
        	foreach( $colunas as $nome )
            {
            	$string .= "\t\t" . '<th>'. ucfirst( $nome ) .' </th>'."\n";
            }
            
			$string .= "\t\t" . '<th></th>'."\n";
		    $string .= "\t" . '</tr>'."\n";
		    $string .= "\t" . '</thead>'."\n";
		    $string .= "\t" . '<tbody>'."\n";
		    
			$string .= "\t" . '<?php foreach( $this->listar'. ucfirst( $tableName ) .' as $'.strtolower( $tableName ).' ) { ?>'."\n";
			$string .= "\t" . '<tr>' . "\n " ;
			
        	foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            	
            	if ( $flags == 'id_' && substr($nome, 3) != $tableName )
            	{
            		$string .= "\t\t" . '<td><?php echo ""; ?></td>'."\n";
            	}
            	else
            	{
            		$string .= "\t\t" . '<td><?php echo $'.strtolower( $tableName ).'->get'.ucfirst($nome).'(); ?></td>'."\n";
            	}
            	
            } 
			
			$string .= "\t\t" . '<td align="right">'."\n";
			$string .= "\t\t\t" . '<a href="<?php echo URL;?>'.$tableName.'/form/<?php echo $'.strtolower( $tableName ).'->getId_'.strtolower( $tableName ).'();?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>'."\n";
			$string .= "\t\t\t" . '<a href="<?php echo URL;?>'.$tableName.'/delete/<?php echo $'.strtolower( $tableName ).'->getId_'.strtolower( $tableName ).'();?>" class="delete btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>'."\n";
			$string .= "\t\t" . '</td>' . "\n";
			$string .= "\t\t" . '</tr>' . "\n";
			$string .= "\t" . '<?php } ?>' . "\n";
			$string .= "\t" . '</tbody>' . "\n";
			$string .= '</table>'."\n";
			
			
			$string .= "\n\n" . '<script>';
			$string .= "\n" . '$(function() {';
			$string .= "\n\t" . '$(".delete").click(function(e) {';
			$string .= "\n\t\t" . 'var c = confirm("Deseja realmente deletar este registro?");';
			$string .= "\n\t\t" . 'if (c == false) return false;';
			$string .= "\n\t" . "}); \n });\n</script>";
			
			$this->createFile( $path, $fileName, $string );
        }
    }
    
    /**
     * Cria os arquivos de formularios de cada view
     * @param unknown $result
     */
    private function createForms( $result )
    {
        foreach ( $result as $rowTabela )
    	{
    		$tableName = $rowTabela['Tables_in_'.$this->dbname];
    		$Query = $this->pdo->prepare("SHOW COLUMNS FROM {$tableName}");
    		$Query->execute();
    		 
    		$colunas = array();
    		 
    		while($e = $Query->fetch(PDO::FETCH_ASSOC))
    		{
    			$colunas[] = $e['Field'];
    		}
            // Configura o diretorio e o nome do arquivo
            // --------------------
            $path = $this->pathRoot . 'views/' . $tableName . '/';
            $fileName = 'form.php';
            // --------------
            
            $formHTML  = '';
            
            $formHTML .= "\n" . '<!-- Page Heading -->';
            $formHTML .= "\n" . '<div class="row">';
            $formHTML .= "\n\t" . '<div class="col-lg-12">';
            $formHTML .= "\n\t\t" . '<h1 class="page-header"><?php echo $this->title; ?></h1>';
            $formHTML .= "\n\t\t" . '<ol class="breadcrumb">';
            $formHTML .= "\n\t\t\t" . '<li><a href="<?php echo URL; ?>">Home</a></li>';
            $formHTML .= "\n\t\t\t" . '<li><a href="<?php echo URL; ?>'. $tableName .'"><?php echo $this->title; ?></a></li>';
            $formHTML .= "\n\t\t\t" . '<li class="active"><?php echo $this->title; ?></li>';
            $formHTML .= "\n\t\t" . '</ol>';
            $formHTML .= "\n\t" . '</div>';
            $formHTML .= "\n" . '</div>';
            $formHTML .= "\n" . '<!-- /.row -->';
            
            $formHTML .= "\n\n" . '<form id="form1" name="form1" method="post" action="<?php echo URL;?>'.$tableName.'/<?php echo $this->action;?>/" class="form-horizontal">';
            
            $formHTML .= "\n\n" . '<div class="row">';
            $formHTML .= "\n\n" . '<div class="col-md-6 col-sm-6 col-lg-6">';
            
            $formHTML .= "\n" . '<input type="hidden" name="id'. ucfirst( $tableName ) .'" value="<?=$this->obj->getId_'. $tableName .'()?>" />';
            
            // Inicia os atributos vazios
            // --------------
            foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            	
            	if ( substr($nome, 3) != $tableName )
            	{
            		if ( $flags == 'id_' )
            		{
		                $formHTML .= "\n\n" . '<div class="form-group">';
		                $formHTML .= "\n\t" . '<label for="'. $nome .'" class="col-sm-2 control-label">'. ucfirst( $nome ) .'</label> ';
		                $formHTML .= "\n\t" . '<div class="col-sm-10"> ';
		                $formHTML .= "\n\t" . '<select name="'. $nome .'" id="'. $nome .'"  class="form-control" required="required">';
		                $formHTML .= "\n\t\t" . '<option value=""></option>';
		                $formHTML .= "\n\t" . '</select>';
		                $formHTML .= "\n\t" . '</div>';
		                $formHTML .= "\n" . '</div>';
            		}
            		else
            		{
            			$formHTML .= "\n\n" . '<div class="form-group">';
            			$formHTML .= "\n\t" . '<label for="'. $nome .'" class="col-sm-2 control-label">'. ucfirst( $nome ) .'</label> ';
            			$formHTML .= "\n\t" . '<div class="col-sm-10"> ';
            			$formHTML .= "\n\t\t" . '<input type="text" name="'. $nome .'" id="'. $nome .'"  class="form-control" required="required" value="<?=$this->obj->get'. ucfirst( $nome ) .'()?>" />';
            			$formHTML .= "\n\t" . '</div>';
            			$formHTML .= "\n" . '</div>';
            		}
            	}
            }
            
            $formHTML .= "\n\n" . '<div class="form-group">';
            $formHTML .= "\n\t" . '<div class="col-sm-10  col-sm-offset-2">';
            $formHTML .= "\n\t\t" . '<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />';
            $formHTML .= "\n\t\t" . '<a href="<?php echo URL; ?>'. $tableName .'" class="btn btn-info">Cancelar</a>';
            $formHTML .= "\n\t" . '</div>';
            $formHTML .= "\n" . '</div>';
            
            $formHTML .= "\n\n" . "\n</div>\n</div>\n\n</form>";
            $this->createFile( $path, $fileName, $formHTML );
        }
    }
    
    /**
     * Cria os arquivos controllers
     * @param unknown $result
     */
    private function createController( $result )
    {
    	foreach ( $result as $rowTabela )
        {
            $tableName = $rowTabela['Tables_in_'.$this->dbname];
        	$Query = $this->pdo->prepare("SHOW COLUMNS FROM {$tableName}");
    		$Query->execute();
    	
    		$colunas = array();
    	
    		while($e = $Query->fetch(PDO::FETCH_ASSOC))
    		{
    			$colunas[] = $e['Field'];
    		}
            // Configura o diretorio e o nome do arquivo
            // --------------------
            $path = $this->pathRoot . 'controllers/';
            $fileName = $tableName . '.php';
            
            $string = "<?php ";
            
            $string .= "\n\n".'class '.ucfirst($tableName).' extends Controller {';
            
            // Metodo construtor
            // ---------------
            $string .= "\n\n\t".'public function __construct() {';
            $string .= "\n\t\t".'parent::__construct();';
            $string .= "\n\t\t".'//Auth::handleLogin();';
            $string .= "\n\t".'}';
            
            // Metodo index
            // ---------------
            
            $string .= "\n\n\t/** \n\t* Metodo index\n\t*/\n";
            
            $string .= "\t".'public function index()';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$this->view->title = "' . ucfirst($tableName) . '";';
            $string .= "\n\t\t".'$this->view->listar'.ucfirst($tableName).' = $this->model->listar'.ucfirst($tableName).'();';
            
            $string .= "\n\n\t\t".'$this->view->render( "header" );';
            $string .= "\n\t\t".'$this->view->render( "' . $tableName . '/index" );';
            $string .= "\n\t\t".'$this->view->render( "footer" );';
            $string .= "\n\t".'}';
			
            // Metodo editForm
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo editForm\n\t*/\n";
            
            $string .= "\t".'public function form( $id = NULL )';
            $string .= "\n\t".'{';
            
            $string .= "\n\t\t" . '$this->view->title = "Cadastrar '.ucfirst($tableName).'";';
            $string .= "\n\t\t" . '$this->view->action = "create";';
            $string .= "\n\t\t" . '$this->view->obj = $this->model;';
            
            $string .= "\n\n\t\t" . 'if( $id ) ';
            $string .= "\n\t\t" . '{';
            
            $string .= "\n\t\t\t" . '$this->view->title = "Editar '.ucfirst($tableName).'";';
            $string .= "\n\t\t\t" . '$this->view->action = "edit/".$id;';
            $string .= "\n\t\t\t" . '$this->view->obj = $this->model->obter'.ucfirst($tableName).'( $id );';
            
            $string .= "\n\n\t\t\t".'if ( empty( $this->view->obj ) ) {';
            $string .= "\n\t\t\t\t".'die( "Valor invalido!" );';
            $string .= "\n\t\t\t".'}';
            
            $string .= "\n\t\t" . '}';
            
            $string .= "\n\n\t\t".'$this->view->render( "header" );';
            $string .= "\n\t\t".'$this->view->render( "'. $tableName .'/form" );';
            $string .= "\n\t\t".'$this->view->render( "footer" );';
            $string .= "\n\t".'}';
            
            // Metodo create
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo create\n\t*/\n";
            
            $string .= "\t".'public function create()';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$data = array(';
            
            foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            	
            	if ( substr($nome, 3) != $tableName )
            	{
            		$string .= "\n\t\t\t" . "'{$nome}' => " . '$_POST["' . $nome . '"], ';
            	}
            }
            
            $string .= "\n\t\t".');';
            
            $string .= "\n\n\t\t".'$this->model->create( $data ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );';
            $string .= "\n\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
            
            $string .= "\n\t".'}';
            
            // Metodo edit
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo edit\n\t*/\n";
            
            $string .= "\t".'public function edit( $id )';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$data = array(';
			
			foreach( $colunas as $nome )
			{
				$flags = substr( $nome, 0, 3 );
				 
				if ( substr($nome, 3) != $tableName )
				{
					$string .= "\n\t\t\t" . "'{$nome}' => " . '$_POST["' . $nome . '"], ';
				}
			}
            			
            $string .= "\n\t\t".');';
            
            $string .= "\n\n\t\t".'$this->model->edit( $data, $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );';
            $string .= "\n\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
            
            $string .= "\n\t".'}';
			
            
            // Metodo delete
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo delete\n\t*/\n";
            
            $string .= "\t".'public function delete( $id )';
            $string .= "\n\t".'{';
            
            $string .= "\n\t\t".'$this->model->delete( $id ) ? $msg = base64_encode( "OPERACAO_SUCESSO" ) : $msg = base64_encode( "OPERACAO_ERRO" );';
            $string .= "\n\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
            
            $string .= "\n\t".'}';
			    
			$string .= "\n".'}'."\n";
            
			$this->createFile( $path, $fileName, $string );
        }
    }
    
    /**
     * Cria os arquivos models
     * @param unknown $result
     */
    private function createModel( $result )
    {
    	foreach ( $result as $rowTabela )
    	{
    		$nomeClasse = $rowTabela['Tables_in_'.$this->dbname];
    		
    		$Query = $this->pdo->prepare("SHOW COLUMNS FROM {$nomeClasse}");
    		$Query->execute();
    		
    		$colunas = array();
    		
    		while($e = $Query->fetch(PDO::FETCH_ASSOC))
    		{
    			$colunas[] = $e['Field'];
    		}
    		
    		// ************************************************
            // Configura o diretorio e o nome do arquivo
            // ************************************************
            $path = $this->pathRoot . 'models/';
            $fileName = $nomeClasse . '_model.php';
            
            $string = "<?php \n";
            
            // ************************************************
            // Inclui as classes de chaves estrangeiras
            // ************************************************
           
            $string .= "\n/** \n * Classe ".ucfirst( $nomeClasse )."\n * @author __ \n *\n * Data: ". date('d/m/Y') ."\n */ \n\n";
            
            // Verifica se tem alguma dependecia para fazer os includes
            foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            
            	if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
            	{
            		$string .= "include_once '" . strtolower(substr($nome, 3)) . "_model.php';\n";
            	}
            }
            
            $string .= "\nclass " . ucfirst( $nomeClasse ) . "_Model extends Model\n{\n";
            
            $string .= "\t/** \n\t* Atributos Private \n\t*/\n";
            
            
            // *******************************************
            // Criar os atributos da classe
            // *******************************************
            foreach( $colunas as $nome )
            {
                $flags = substr( $nome, 0, 3 );
                if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
                {
                    // Se for chave estrangeira, retiramos o 'id_' do inicio do nome do campo
                    $string .= "\tprivate $" . strtolower(substr($nome, 3)) . ";\n";
                }
                else
                {
                    $string .= "\tprivate $" . $nome . ";\n";
                }
            }
            $string .= "\n\tpublic function __construct()\n\t{\n\t\t";
            $string .= "parent::__construct();\n";
	        
	        // ************************************************
            // Inicia os atributos vazios
			// ************************************************
	        foreach( $colunas as $nome )
            {
                $flags = substr( $nome, 0, 3 );
                if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
                {
                    $string .= "\n\t\t" . '$this->' . strtolower(substr($nome, 3)) . ' = new ' . ucfirst( substr($nome, 3) ) . '_Model();';
                    
                	//$string .= "\n\t\t" . '$this->' . strtolower(substr($nome, 3)) . ' = "";';
                } 
                else
                {
                    $string .= "\n\t\t" . '$this->' . $nome . " = '';";
                }
                
            }
            
            $string .=  "\n\t}\n\n";
            
            
            // *******************************************
            // Monta os metodos set's
            // ******************************************* 
            
            $string .= "\t/** \n\t* Metodos set's\n\t*/\n";
            
            foreach( $colunas as $nome )
            {
                $flags = substr( $nome, 0, 3 );
                if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
                {
                    $string .= "\tpublic function set" . ucfirst(substr($nome, 3)) . '( '. ucfirst(substr($nome, 3)) .'_Model $' . strtolower(substr($nome, 3)) . ' )' . "\n\t{\n\t";
                    $string .= "\t" . '$this->' . strtolower(substr($nome, 3)) . ' = ' . '$' . strtolower(substr($nome, 3)) . ";\n\t}\n\n";
                }
                else
                {
                    $string .= "\tpublic function set" . ucfirst($nome) . '( $' . $nome . ' )' . "\n\t{\n\t";
                    $string .= "\t" . '$this->' . $nome . ' = ' . '$' . $nome . ";\n\t}\n\n";
                }
            }
            
            
            
            // *********************************************
            // Monta os metodos get's
            // *********************************************
            
            $string .= "\t/** \n\t* Metodos get's\n\t*/\n";
            
            foreach( $colunas as $nome )
            {
                //$nome = $e['Field'];
                $flags = substr( $nome, 0, 3 );
                if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
                {
                    $string .= "\tpublic function get" . ucfirst(substr($nome, 3)) . '()' . "\n\t{\n\t";
                    $string .= "\treturn " . '$this->' . strtolower(substr($nome, 3)) . ";\n\t}\n\n";
                }
                else
                {
                    $string .= "\tpublic function get" . ucfirst($nome) . '()' . "\n\t{\n\t";
                    $string .= "\treturn " . '$this->' . $nome . ";\n\t}\n\n";
                }
            }
            
            
            // Metodo create
            // ---------------
            $string .= "\n\t/** \n\t* Metodo create\n\t*/\n";
            
            $string .= "\t" . 'public function create( $data )';
            $string .= "\n\t" .'{';
            $string .= "\n\t\t" . '$this->db->beginTransaction();';
            
            $string .= "\n\n\t\t" .'if( !$id = $this->db->insert( "'. $nomeClasse .'", $data ) ){';
            $string .= "\n\t\t\t" .'$this->db->rollBack();';
            $string .= "\n\t\t\t" .'return false;';
            $string .= "\n\t\t" .'}';
            
            $string .= "\n\n\t\t" .'$this->db->commit();';
            $string .= "\n\t\t" .'return true;';
            
            $string .= "\n\t" .'}';
            
            
            // Metodo edit
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo edit\n\t*/\n";
            
            $string .= "\t" . 'public function edit( $data, $id )';
            $string .= "\n\t" . '{';
            
            $string .= "\n\t\t" . '$this->db->beginTransaction();';
            
            $string .= "\n\n\t\t" .'if( !$update = $this->db->update("' . $nomeClasse . '", $data, "id_' . $nomeClasse . ' = {$id} ") ){';
            $string .= "\n\t\t\t" .'$this->db->rollBack();';
            $string .= "\n\t\t\t" .'return false;';
            $string .= "\n\t\t" .'}';
            
            $string .= "\n\n\t\t" .'$this->db->commit();';
            $string .= "\n\t\t" .'return $update;';
            
            $string .= "\n\t" .'}';
            
            
            // Metodo delete
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo delete\n\t*/\n";
            
            $string .= "\t" . 'public function delete( $id )';
            $string .= "\n\t" . '{';
            $string .= "\n\t\t" . '$this->db->beginTransaction();';
            $string .= "\n\n\t" . '	if( !$delete = $this->db->delete("'. $nomeClasse .'", "id_'. $nomeClasse .' = {$id} ") ){ ';
            $string .= "\n\t\t\t" .'$this->db->rollBack();';
            $string .= "\n\t\t\t" .'return false;';
            $string .= "\n\t\t" .'}';
            
            $string .= "\n\n\t\t" .'$this->db->commit();';
            $string .= "\n\t\t" .'return $delete;';
            $string .= "\n\t" . '}';
            
            
            // Metodo obter
            // ---------------
            
            $string .= "\n\n\t/** \n\t* Metodo obter".ucfirst($nomeClasse)."\n\t*/\n";
            
            $string .= "\tpublic function obter" . ucfirst($nomeClasse) . '( $id_' . $nomeClasse . " )\n\t{";
            
            $string .= "\n\t\t" . '$sql  = "select * ";';
            $string .= "\n\t\t" . '$sql .= "from ' . $nomeClasse . ' ";';
            $string .= "\n\t\t" . '$sql .= "where id_' . $nomeClasse . ' = :id ";';
            
            $string .= "\n\n\t\t" . '$result = $this->db->select( $sql, array("id" => $id_' . $nomeClasse . ') );';
            
            $string .= "\n\t\t" . 'return $this->montarObjeto( $result[0] );';
            
            $string .= "\n\t}";
            
            // Metodo listar
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo listar".ucfirst($nomeClasse)."\n\t*/\n";
            $string .= "\t";
            $string .= 'public function listar' . ucfirst($nomeClasse) . '()' . "\n\t{\n\t\t";
            $string .= '$sql  = "select * ";' . "\n\t\t";
            $string .= '$sql .= "from '. $nomeClasse .' ";' . "\n\n\t\t";
            $string .= 'if ( isset( $_POST["like"] ) )' . "\n\t\t{\n\t\t\t";
            
            $string .= '$sql .= "where id_' . $nomeClasse . ' like :id "; // Configurar o like com o campo necessario da tabela ';
            $string .= "\n\t\t\t" . '$result = $this->db->select( $sql, array("id" => "%{$_POST["like"]}%") );';
            
            $string .= "\n\t\t}\n\t\telse";
            $string .= "\n\t\t\t" . '$result = $this->db->select( $sql );';
            
            $string .= "\n\n\t\t" . 'return $this->montarLista($result);';
            
            $string .= "\n\t}";
            
            // Metodo montarLista
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo montarLista\n\t*/\n";
            
            $string .= "\t" . 'private function montarLista( $result )' . "\n\t{";
            $string .= "\n\t\t" . '$objs = array();';
            $string .= "\n\t\t" . 'if( !empty( $result ) )' . "\n\t\t{";
            $string .= "\n\t\t\t" . 'foreach( $result as $row )' . "\n\t\t\t{";
            $string .= "\n\t\t\t\t" . '$obj = new self();';
            $string .= "\n\t\t\t\t" . '$obj->montarObjeto( $row );';
            $string .= "\n\t\t\t\t" . '$objs[] = $obj;';
            $string .= "\n\t\t\t\t" . '$obj = null;' . "\n\t\t\t}";
            
            
            $string .= "\n\t\t}";
            $string .= "\n\t\t" . 'return $objs;';
            $string .= "\n\t}";
			
            
            // Método montarObjeto
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo montarObjeto\n\t*/\n";
            
            $string .= "\t" . 'private function montarObjeto( $row )' . "\n\t{";
            foreach( $colunas as $nome )
            {
                //$nome = $e['Field'];
                $flags = substr( $nome, 0, 3 );
                if ( $flags == 'id_' && substr($nome, 3) != $nomeClasse )
                {
                    $nomeTemp = ucfirst(substr($nome, 3));
                    $string .= "\n\n\t\t" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '_Model();';
                    $string .= "\n\t\t" . '$obj' . $nomeTemp . '->obter' . $nomeTemp . '( $row["id_' . strtolower($nomeTemp) . '"] );' ;
                    $string .= "\n\t\t" . '$this->set' . ucfirst(substr($nome, 3)) . '( ' . '$obj' . $nomeTemp . ' );';
                    //$string .= "\n\t\t" . '$this->set' . ucfirst(substr($nome, 3)) . '( $row["' . $nome . '"] );';
                } else
                {
                    $string .= "\n\t\t" . '$this->set' . ucfirst($nome) . '( $row["' . $nome . '"] );';
                }
                
            }
			
            $string .= "\n\n\t\t" . 'return $this;';
            
            $string .= "\n\t}";
            $string .= "\n}\n?>";
            
            $this->createFile( $path, $fileName, $string );
            
        }
    }
}
new Mvc();