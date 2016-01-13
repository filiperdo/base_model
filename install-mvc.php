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
    	$this->host = "localhost";
        $this->user = "root";
        $this->password = "";
        $this->dbname = "dbname";
        
        try{
        	$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname, $this->user, $this->password);
        }
        catch ( PDOException $e )
        {
        	echo "Erro!: " . $e->getMessage();
        }
        
        $this->pathRoot = '_files/mvc';
        
        if( !is_dir( $this->pathRoot ) )
            mkdir( $this->pathRoot, 0777);
        
        $sql = 'show tables from ' . $this->dbname;

        $result = $this->pdo->query($sql);
        $result = $result->fetchAll(PDO::FETCH_ASSOC);
        
        //var_dump( $result );
        
        $this->createModel( $result );
        
        $this->createController( $result );
        
        $this->createForms( $result );
        
    	$this->createViews( $result );
    	
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
            $path = $this->pathRoot . '/views/ ' . $tableName . '/';
            $fileName = 'index.php';
            
            $string  = '';
            $string .= '<!-- Page Heading -->';
            $string .= "\n" . '<div class="row">';
            $string .= "\n" . '<div class="col-lg-12">';
            $string .= "\n" . '<h1 class="page-header"><?php echo $this->title; ?></h1>';
            $string .= "\n" . '<div class="row">';
            $string .= "\n" . '<div class="col-lg-6 col-md-6">';
            $string .= "\n" . '<ol class="breadcrumb">';
            $string .= "\n" . '<li><a href="index.php">Home</a></li>';
            $string .= "\n" . '<li class="active"><?php echo $this->title; ?></li>';
            $string .= "\n" . '</ol></div>';
            $string .= "\n" . '<div class="col-lg-4 col-md-3">';
            $string .= "\n" . '<div class="form-group input-group">';
            $string .= "\n" . '<input type="text" class="form-control" id="busca">';
            $string .= "\n" . '<span class="input-group-btn">';
            $string .= "\n" . '<button class="btn btn-default" type="button">';
            $string .= "\n" . '<i class="glyphicon glyphicon-search"></i>';
            $string .= "\n" . '</button></span></div></div>';
            $string .= "\n" . '<div class="col-lg-2 col-md-2">';
            $string .= "\n" . '<a href="<?php echo URL;?>'.$tableName.'/form" class="btn btn-success">Cadastrar <?php echo $this->title; ?></a>';
            $string .= "\n</div>\n</div>\n</div>\n</div>";
            $string .= "\n" . '<!-- /.row -->';

			$string .= "\n\n" . '<?php if (isset($_GET["st"])) { $objAlert = new Alerta($_GET["st"]); } ?>' . "\n\n";
			
			$string .= '<table class="table-striped sortable">'."\n";
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
		    
			$string .= "\t" . '<?php foreach( $this->listar'. ucfirst( $tableName ) .'( $objPaginacao ) as $'.strtolower( $tableName ).' ) { ?>'."\n";
			$string .= "\t" . '<tr>' . "\n " ;
			
        	foreach( $colunas as $nome )
            {
            	$string .= "\t\t" . '<td><?php echo $'.strtolower( $tableName ).'->get'.ucfirst($nome).'(); ?></td>'."\n";
            } 
			        
			$string .= "\t\t" . '<td align="right">'."\n";
			$string .= "\t\t\t" . '<a href="<?php echo URL;?>'.$tableName.'/form/<?php echo $'.strtolower( $tableName ).'->getId_'.strtolower( $tableName ).'();?>" class="btn btn-info btn-sm"><i class="glyphicon glyphicon-pencil"></i></a>'."\n";
			$string .= "\t\t\t" . '<a href="<?php echo URL;?>'.$tableName.'/delete/<?php echo $'.strtolower( $tableName ).'->getId_'.strtolower( $tableName ).'();?>" class="delete btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i></a>'."\n";
			$string .= "\t\t" . '</td>' . "\n";
			$string .= "\t\t" . '</tr>' . "\n";
			$string .= "\t" . '<?php } ?>' . "\n";
			$string .= "\t" . '</tbody>' . "\n";
			$string .= '</table>'."\n";
			
			$string .= '</div><!-- .row -->'."\n";
			
			$string .= "\n\n" . '<script>';
			$string .= "\n" . '$(function() {';
			$string .= "\n\t" . '$(".delete").click(function(e) {';
			$string .= "\n\t" . 'var c = confirm("Deseja realmente deletar este registro?");';
			$string .= "\n\t" . 'if (c == false) return false;';
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
            $path = $this->pathRoot . '/views/ ' . $tableName . '/';
            $fileName = 'form.php';
            // --------------
            
            $formHTML  = '<?php' . "\n\n";
                        
            // Instancia as classes de chaves estrangeiras
            // ----------------
            foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            
            	if ( $flags == 'id_' )
            	{
                    $formHTML .= "\n" . '$obj' . ucfirst( strtolower(substr($nome, 3)) ) . ' = new ' . ucfirst( strtolower(substr($nome, 3)) ) . '();';
                }
            }
            
            $formHTML .= "\n\n" . 'if( isset( $_GET["id'. ucfirst( $tableName ) .'"] ) )';
            $formHTML .= "\n" . '{';
            
            $formHTML .= "\n\t" . '$obj'. ucfirst( $tableName ) .'->obter'. ucfirst( $tableName ) .'( $_GET["id'. ucfirst( $tableName ) .'"] );';
            $formHTML .= "\n" . '}';
            $formHTML .= "\n\n" . '?>';
            
            
            $formHTML .= "\n" . '<!-- Page Heading -->';
            $formHTML .= "\n" . '<div class="row">';
            $formHTML .= "\n" . '<div class="col-lg-12">';
            $formHTML .= "\n" . '<h1 class="page-header">Formulario <?php $this->title; ?></h1>';
            $formHTML .= "\n" . '<ol class="breadcrumb">';
            $formHTML .= "\n" . '<li><a href="index.php">Home</a></li>';
            $formHTML .= "\n" . '<li><a href="index.php?p=escola-lista"><?php $this->title; ?></a></li>';
            $formHTML .= "\n" . '<li class="active">Cadastrar escola</li>';
            $formHTML .= "\n" . '</ol>';
            $formHTML .= "\n" . '</div>';
            $formHTML .= "\n" . '</div>';
            $formHTML .= "\n" . '<!-- /.row -->';
            
            $formHTML .= "\n" . '<form id="form1" name="form1" method="post" action="<?php echo URL;?>'.$tableName.'/create/">';
            
            $formHTML .= "\n\n" . '<div class="container-fluid">';
            $formHTML .= "\n\n" . '<div class="col-md-6 col-sm-6 col-lg-6">';
            $formHTML .= "\n\n" . '<div class="row">';
            
            $formHTML .= "\n\n" . '<h2 class="sub-header"> <?php echo $this->title; ?> </h2>';
            
            $formHTML .= "\n" . '<input type="hidden" name="id'. ucfirst( $tableName ) .'" value="<?=$obj'. ucfirst( $tableName ) .'->getId_'. $tableName .'()?>" />';
            
            // Inicia os atributos vazios
            // --------------
            foreach( $colunas as $nome )
            {
            	$flags = substr( $nome, 0, 3 );
            
            	if ( $flags == 'id_' )
            	{
                    $formHTML .= "\n\n" . '<div class="form-group">';
                    $formHTML .= "\n\t" . '<label for="'. strtolower(substr($nome, 3)) .'" class="control-label col-xs-3">'. $nome .'</label>';
                    $formHTML .= "\n\n" . '<div class="col-xs-8">';
                    $formHTML .= "\n\t" . '<select name="'. strtolower(substr($nome, 3)) .'" id="'. strtolower(substr($nome, 3)) .'" class="form-control" required="required">';
                    $formHTML .= "\n\t" . '<option value="" disabled="disabled" selected="selected">Selecione a '. strtolower(substr($nome, 3)) .'</option>';
                    $formHTML .= "\n\t" . '<?php foreach( $obj'.ucfirst(substr($nome, 3)).'->listar'.ucfirst(substr($nome, 3)).'() as $'. strtolower(substr($nome, 3)) .' ) { ?>';
                    $formHTML .= "\n\t\t" . '<option value="<?=$'. strtolower(substr($nome, 3)) .'->getId_'.substr($nome, 3).'()?>" <?php if( $'. strtolower(substr($nome, 3)) .'->getId_'.substr($nome, 3).'() == $obj'.ucfirst( $tableName ).'->get'.ucfirst($nome).'() ){ ?>selected="selected"<?php } ?>>';
                    $formHTML .= "\n\t\t" . '<?php echo $'. strtolower(substr($nome, 3)) .'->getId_'.substr($nome, 3).'()?></option>';
                    $formHTML .= "\n\t" . '<?php } ?>';
                    $formHTML .= "\n\t" . '</select>';
                    $formHTML .= "\n" . '</div>';
                    $formHTML .= "\n" . '</div>';
                }
                else
                {
                    $formHTML .= "\n\n" . '<div class="form-group">';
                    $formHTML .= "\n\t" . '<label class="control-label col-xs-3" for="'. $nome .'">'. ucfirst( $nome ) .'</label> ';
                    $formHTML .= "\n\t" . '<div class="col-xs-8">';
                    $formHTML .= "\n\t\t" . '<input type="text" name="'. $nome .'" id="'. $nome .'"  class="form-control" required="required" value="<?=$obj'. ucfirst( $tableName ) .'->get'. ucfirst( $nome ) .'()?>" />';
                    $formHTML .= "\n\t" . '</div>';
                    $formHTML .= "\n" . '</div>';
                }
            }
            
            $formHTML .= "\n\n" . '<div class="form-group">';
            $formHTML .= "\n\n" . '<div class="col-xs-offset-3 col-xs-9">';
            $formHTML .= "\n\t" . '<a href="index.php?p='. $tableName .'-lista" class="btn btn-info">Cancelar</a>';
            $formHTML .= "\n\t" . '<input type="submit" name="salvar" id="salvar" value="Salvar" class="btn btn-success" />';
            $formHTML .= "\n" . '</div>';
            $formHTML .= "\n" . '</div>';
            
            $formHTML .= "\n\n" . "\n</div>\n</div>\n</div>\n\n</form>";

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
            $path = $this->pathRoot . '/controllers/';
            $fileName = $tableName . '.php';
            
            $string = "<?php ";
            
            $string .= "\n\n".'class '.ucfirst($tableName).' extends Controller {';
            
            // Metodo construtor
            // ---------------
            $string .= "\n\n\t".'public function __construct() {';
            $string .= "\n\t\t".'parent::__construct();';
            $string .= "\n\t\t".'Auth::handleLogin();';
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
            
            $string .= "\t".'public function editForm($id)';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$this->view->'.$tableName.' = $this->model->obter'.ucfirst($tableName).'( $id );';
            
            $string .= "\n\n\t\t".'if ( empty( $this->view->'. $tableName .' ) ) {';
            $string .= "\n\t\t\t".'die( "Valor invalido!" );';
            $string .= "\n\t\t".'}';
            
            $string .= "\n\n\t\t".'$this->view->title = "Editar '. ucfirst($tableName) .'";';
            
            $string .= "\n\t\t".'$this->view->render( "header" );';
            $string .= "\n\t\t".'$this->view->render( "'. $tableName .'/editForm" );';
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
            	$string .= "\n\t\t\t" . "'{$nome}' => " . '$_POST["' . $nome . '"], ';
            }
            
            $string .= "\n\t\t".');';
            $string .= "\n\n\t\t".'$this->model->create( $data );';
            
            $string .= "\n\t\t".'$msg = base64_encode( "OPERACAO_SUCESSO" );';
            $string .= "\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
            
            $string .= "\n\t".'}';
            
            // Metodo edit
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo edit\n\t*/\n";
            
            $string .= "\t".'public function edit( $id )';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$data = array(';
			$string .= "\n\t\t\t".'"id_' . $tableName . '" 	=> $id,';
			
			foreach( $colunas as $nome )
			{
				$string .= "\n\t\t\t" . "'{$nome}' => " . '$_POST["' . $nome . '"], ';
			}
            			
            $string .= "\n\t\t".');';
            $string .= "\n\n\t\t".'$this->model->edit( $data );';
            $string .= "\n\t\t".'$msg = base64_encode( "OPERACAO_SUCESSO" );';
            $string .= "\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
            $string .= "\n\t".'}';
			
            
            // Metodo delete
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo delete\n\t*/\n";
            
            $string .= "\t".'public function delete( $id )';
            $string .= "\n\t".'{';
            $string .= "\n\t\t".'$this->model->delete( $id );';
            $string .= "\n\t\t".'$msg = base64_encode( "OPERACAO_SUCESSO" );';
            $string .= "\n\t\t".'header("location: " . URL . "'.$tableName.'?st=".$msg);';
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
            $path = $this->pathRoot . '/models/';
            $fileName = $nomeClasse . '_model.php';
            
            $string = "<?php \n";
            
            // ************************************************
            // Inclui as classes de chaves estrangeiras
            // ************************************************
           
            $string .= "\n/** \n * Classe ".ucfirst( $nomeClasse )."\n * @author __ \n *\n * Data: ". date('d/m/Y') ."\n */";
            
            $string .= "\nclass " . ucfirst( $nomeClasse ) . "_Model extends Model\n{\n";
            
            $string .= "\t/** \n\t* Atributos Private \n\t*/\n";
            
            
            // *******************************************
            // Criar os atributos da classe
            // *******************************************
            foreach( $colunas as $nome )
            {
                $flags = substr( $nome, 0, 3 );

                if ( $flags == 'id_' )
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
                $flags = substr( $e['Field'], 0, 3 );

                if ( $flags == 'id_' )
                {
                    //$nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 3));

                    //$string .= "\n\n\t\t" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '();';
                    //$string .= "\n\t\t" . '$this->' . strtolower(substr($nome, 3)) . ' = $obj' . $nomeTemp . ';';
                    
                	$string .= "\n\t\t" . '$this->' . strtolower(substr($nome, 3)) . ' = "";';
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
                $flags = substr( $e['Field'], 0, 3 );

                if ( $flags == 'id_' )
                {
                    $string .= "\tpublic function set" . ucfirst(substr($nome, 3)) . '( $' . strtolower(substr($nome, 3)) . ' )' . "\n\t{\n\t";
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

                $flags = substr( $e['Field'], 0, 3 );

                if ( $flags == 'id_' )
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
            $string .= "\n\t" .'	$this->db->insert("'. $nomeClasse .'", array(';
            
            foreach( $colunas as $nome )
            {
            	$string .= "\n\t\t\t" . "'{$nome}' \t\t=> " . '$data["' . $nome . '"],';
            }
            
            $string .= "\n\t\t" .'));';
            $string .= "\n\t" .'}';
            
            
            // Metodo edit
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo edit\n\t*/\n";
            
            $string .= "\t" . 'public function edit( $data )';
            $string .= "\n\t" . '{';
            $string .= "\n\t\t" . '$postData = array(';
            
    		foreach( $colunas as $nome )
            {
            	$string .= "\n\t\t\t" . "'{$nome}' => " . '$data["' . $nome . '"],';
            }
            
            $string .= "\n\t\t" .');';
            
            $string .= "\n\n\t\t" .'$this->db->update("' . $nomeClasse . '", $postData, "id_' . $nomeClasse . ' = ' . '{$data['."'id_" . $nomeClasse ."'" . ']} ");';
 
            $string .= "\n\t" .'}';
            
            
            // Metodo delete
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo delete\n\t*/\n";
            
            $string .= "\t" . 'public function delete( $id )';
            $string .= "\n\t" . '{';
            $string .= "\n\t" . '	$this->db->delete("'. $nomeClasse .'", "id_'. $nomeClasse .' = {$id} ");';
            $string .= "\n\t" . '}';
            
            
            // Metodo obter
            // ---------------
            
            $string .= "\n\n\t/** \n\t* Metodo obter".ucfirst($nomeClasse)."\n\t*/\n";
            
            $string .= "\tpublic function obter" . ucfirst($nomeClasse) . '( $id_' . $nomeClasse . " )\n\t{\n\t\t";
            $string .= '$result = $this->db->obterRegistroPorId( "' . $nomeClasse . '", $id_' . $nomeClasse . ' );' . "\n";
            $string .= "\t\t" . 'return $this->montarObjeto( $result->fetch_array() );' . "\n\t}";
            
            // Metodo listar
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo listar".ucfirst($nomeClasse)."\n\t*/\n";
            $string .= "\t";
            $string .= 'public function listar' . ucfirst($nomeClasse) . '( Paginacao $objPaginacao = NULL )' . "\n\t{\n\t\t";
            $string .= '$sql  = "select * ";' . "\n\t\t";
            $string .= '$sql .= "from '. $nomeClasse .' ";' . "\n\n\t\t";
            $string .= 'if ($objPaginacao)' . "\n\t\t{\n\t\t\t";
            $string .= '$sql .= "limit " . $objPaginacao->getInicio() . "," . $objPaginacao->getResultPorPagina();' . "\n\t\t}";
            $string .= "\n\n\t\t" . '$result = $this->db->executarSQL($sql);';
            $string .= "\n\n\t\t" . 'if ( $result->num_rows > 0 )';
            $string .= "\n\t\t\t" . 'return $this->montarLista($result);';
            $string .= "\n\t\t" . 'else';
            $string .= "\n\t\t\t" . 'return array();' . "\n\t}";
            
            // Metodo montarLista
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo montarLista\n\t*/\n";
            
            $string .= "\t" . 'private function montarLista( $result )' . "\n\t{";
            $string .= "\n\t\t" . 'if( $result->num_rows > 0 )' . "\n\t\t{";
            $string .= "\n\t\t\t" . 'while( $row = $result->fetch_array() )' . "\n\t\t\t{";
            $string .= "\n\t\t\t\t" . '$obj = new self();';
            $string .= "\n\t\t\t\t" . '$obj->montarObjeto( $row );';
            $string .= "\n\t\t\t\t" . '$objs[] = $obj;';
            $string .= "\n\t\t\t\t" . '$obj = null;' . "\n\t\t\t}";
            $string .= "\n\t\t\t" . 'return $objs;' . "\n\t\t}";
            $string .= "\n\t\telse\n\t\t{";
            $string .= "\n\t\t\treturn false;\n\t\t}\n\t}";


            // Método montarObjeto
            // ---------------
            $string .= "\n\n\t/** \n\t* Metodo montarObjeto\n\t*/\n";
            
            $string .= "\t" . 'private function montarObjeto( $row )' . "\n\t{";

            foreach( $colunas as $nome )
            {
                //$nome = $e['Field'];

                $flags = substr( $e['Field'], 0, 3 );

                if ( $flags == 'id_' )
                {
                    //$nomeTemp = ucfirst(substr(mysql_field_name($resField, $i), 3));

                    //$string .= "\n\n\t\t" . '$obj' . $nomeTemp . ' = new ' . $nomeTemp . '();';
                    //$string .= "\n\t\t" . '$obj' . $nomeTemp . '->obter' . $nomeTemp . '( $row["id_' . strtolower($nomeTemp) . '"] );' . "\n";

                    //$string .= "\n\t\t" . '$this->set' . ucfirst(substr($nome, 3)) . '( ' . '$obj' . $nomeTemp . ' );';
                    $string .= "\n\t\t" . '$this->set' . ucfirst(substr($nome, 3)) . '( $row["' . $nome . '"] );';
                } else
                {
                    $string .= "\n\t\t" . '$this->set' . ucfirst($nome) . '( $row["' . $nome . '"] );';
                }
                
            }

            $string .= "\n\t}";

            $string .= "\n}\n?>";
            
            $this->createFile( $path, $fileName, $string );
            
        }
    }
}

new Mvc();
