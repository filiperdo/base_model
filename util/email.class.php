<?php

require_once 'util/class.phpmailer.php'; 
require_once 'models/user_model.php';

/**
 * Classe que configura todos os envios de emails do sistema
 * @author Filipe Rodrigues
 *
 */
class Email
{
    public $mail;
    public $corpoRodape;
    
    public function __construct()
    {
        $this->mail = new PHPMailer();

        // Define os dados do servidor e tipo de conexão
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->isSMTP(true); // Define que a mensagem será SMTP
        
        $this->mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
        $this->mail->Mailer = 'smtp';
        
        $this->mail->Host = AWS_HOST_SMTP; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
        $this->mail->Username = AWS_USERNAME; // Usuário do servidor SMTP (endereço de email)
        $this->mail->Password = AWS_PASSWORD; // Senha do servidor SMTP (senha do email usado)
     	$this->mail->SMTPSecure = 'ssl';
     	$this->mail->Port = 465; // 587
     	
        $this->mail->isHTML(true);
		
		$this->mail->SMTPDebug = 0;
		//$this->mail->Port = AWS_PORT; // 587
       
        // Define o remetente
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        $this->mail->From = "no-reply@robo3d.com.br"; // Seu e-mail
        $this->mail->FromName = "Robo 3D"; // Seu nome
        
        $this->configurarDadosPadroes();
    }
    
    /**
     * Configura alguns dados padrões dos e-mail de ações
     * do sistema, como assunto e rodapé do corpo do e-mail
     */
    private function configurarDadosPadroes()
    {
        // Configura o rodape do corpo do e-mail a ser enviado

        $this->corpoRodape  = "<br/><br/>Grande abraço!<br/>";
        $this->corpoRodape .= "Equipe Robô 3D<br/>";
        $this->corpoRodape .= "<a href='http://www.robo3d.com.br' target='_blank'>www.robo3d.com.br</a>";
    }

    /**
     * Envia um e-mail de acordo com 
     * as configuração dos atributos
     */
    public function enviar()
    { 
        // Define os anexos (opcional)
        // =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
        
        // Envia o e-mail
        $enviado = $this->mail->Send();
        
        //echo $this->mail->Body;
        
        // Limpa os destinatários e os anexos
        $this->mail->ClearAllRecipients();
        $this->mail->ClearAttachments();

        
        if ($enviado)
        {
            //echo 'Enviou';
            return true;
        }
        else
        {
            //echo 'Não enviou';
            return false;
        }

    }
    
    public function enviarBoasVindas()
    {
    	$this->mail->Subject = "Teste Robo3D";
    	$this->mail->AddAddress( 'frodrigues@anacom.com.br' );
    	
    	// Envia uma copia do e-mail
    	//$this->mail->addBCC( '' );
    	
    	// Configura o corpo do email
    	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    	$this->mail->Body  = "Oi <strong>" . 'Filipe Rodrigues' . "</strong>, tudo bem?<br/>";
    	
    	$this->mail->Body .= "Seja bem vindo a comunidade Robo 3D!<br/>";
    	$this->mail->Body .= "Esperamos que você aproveite o máximo que este portal pode te oferecer.<br/><br/> ";
    	
    	$this->mail->Body .= "Para você não esquecer:<br/> ";
    	$this->mail->Body .= "Endereço do portal: <a href='http://www.robo3d.com.br'>www.robo3d.com.br</a><br/>";
    	$this->mail->Body .= "Seu login: <strong>" . 'teste' . "</strong><br/>";
    	$this->mail->Body .= "Sua senha: <strong>" . 'teste' . "</strong> (pode ser alterada posteriormente)<br/><br/>";
    	//$this->mail->Body .= "Qualquer problema com acesso ao site, entre em contato através do e-mail: contato@robo3d.com.br";
    	
    	$this->mail->Body .= $this->corpoRodape;
    	
    	$enviar = $this->enviar();
    	
    	return $enviar;
    	
    }
    
    /**
     * Faz a validação do token para efetuar o cadastro
     * @return unknown
     */
    public function enviarValidacaoCadastro( $login, $email, $token )
    {
    	$this->mail->Subject = "Robo3D - Confirmacao de cadastro";
    	$this->mail->AddAddress( trim( $email ) );
    	$this->mail->AddBCC('frodrigues@anacom.com.br');
    	
    	// Configura o corpo do email
    	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-
    	$this->mail->Body  = "Oi <strong>" . $login . "</strong>, tudo bem?<br/>";
    	
    	$this->mail->Body .= "Obrigado por se cadastrar na comunidade do Robo 3D!<br/><br/>";
    	$this->mail->Body .= "Para ativar a sua conta, por favor clique no link abaixo:<br/> ";
    	
    	$this->mail->Body .= "<a href='".URL."user/activate/{$token}' target='_blank'>".URL."user/activate/{$token}</a><br/><br/>";
    	
    	$this->mail->Body .= "Agora você pode começar a usar todos os nossos serviços.<br/> ";
    	$this->mail->Body .= "Esperamos que você aproveite o máximo que este portal pode te oferecer. ";
    	
    	$this->mail->Body .= $this->corpoRodape;
    	 
    	$enviar = $this->enviar();
    	 
    	return $enviar;
    }

    /**
     * Envia a senha para o email vinculado
     * @param unknown $email
     * @param unknown $senha
     * @return boolean
     */
    public function enviarSenhaRecuperada( User_Model $user )
    {
    	
    	$this->mail->Subject = "Robo3D - Senha!";
    	$this->mail->AddAddress( $user->getEmail() );
    
    	// Configura o corpo do email
    	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    	$this->mail->Body  = "Oi <strong>" . $user->getLogin() . "</strong>, tudo bem?<br/>";
    	$this->mail->Body .= "Sua senha foi recuperada com sucesso!<br/><br/> ";
    
    	$this->mail->Body .= "Para você não esquecer:<br/> ";
    	$this->mail->Body .= "Endereço do portal: <a href='".URL."'>" . URL . '</a><br/>';
    	$this->mail->Body .= "Seu login: <strong>" . $user->getLogin() . "</strong><br/>";
    	$this->mail->Body .= "Sua senha: <strong>" . $user->getPassword() . "</strong><br/>";
    
    	$this->mail->Body .= $this->corpoRodape;
    
    	$enviar = $this->enviar();
    
    	return $enviar;
    	
    }
    
    
    /**
     * Teste de envio
     * @return unknown
     */
    public function teste_envio()
    {
    	$this->mail->Subject = "Robo3D - Teste!";
    	$this->mail->AddAddress( 'filiperdo@gmail.com' );
    	
    	// Configura o corpo do email
    	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    	$this->mail->Body  = "Oi <br/>";
    	
    	
    	$this->mail->Body .= $this->corpoRodape;
    	
    	$enviar = $this->enviar();
    	
    	return $enviar;
    }

}
?>