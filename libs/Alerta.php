<?php

/**
 * Classe para formatar e exibir as mensagens de
 * operacao do sistema
 * @author filipe.rodrigues
 *
 */
class Alerta
{
    const CLASSE_CSS = 'alert';
    const LISTA_VAZIA = 'Sua lista está vazia.';

    private $arrayMsgOk;
    private $arrayMsgErro;

    function __construct($msg = '')
    {
        $this->arrayMsgErro = array();
        $this->arrayMsgOk = array();

        // Mensagens de Ok
        $this->arrayMsgOk['OPERACAO_SUCESSO'] = "Opera&ccedil;&atilde;o realizada com sucesso!";
        $this->arrayMsgOk['SENHA_SUCESSO'] = "Senha atualizada com sucesso!";
        $this->arrayMsgOk['CADATRO_ATIVADO'] = "Cadastro ativado com sucesso!<br>Utilize os campos acima para fazer login.";
        $this->arrayMsgOk['EMAIL_REDEFINIR_SENHA'] = 'E-mail enviado!<br/>Por favor, confira seu e-mail para recuperar sua senha.';
		$this->arrayMsgOk['CADASTRO_SUCESSO'] = 'Cadastro efetuado com sucesso!<br/>Acesse seu e-mail para concluir o cadastro.';
        
        
        // Mensagens de Erro
		
		$this->arrayMsgErro['RECAPTCHA_INCORRETO'] = "Não foi possível efetuar o cadastro. Não conseguimos validar o reCaptcha!";
        $this->arrayMsgErro['OPERACAO_ERRO'] = "Erro ao executar a operacao!";
        $this->arrayMsgErro['EXCLUIR_REGISTRO_REL'] = 'Não foi possível excluir este registro, porque ele está sendo utilizado!';
        $this->arrayMsgErro['REL_EXISTENTE'] = "Este(s) relacionamento(s) já existe(m) no banco de dados!";
        $this->arrayMsgErro['LOGIN_INCORRETO'] = "Dados incorretos!";
        $this->arrayMsgErro['EMAIL_NAO_ENCONTRADO'] = 'O e-mail não foi encontrado em nosso sistema!';
        $this->arrayMsgErro['LOGIN_ERRO'] = "Erro ao executar a operação! Este e-mail já existe!";
        $this->arrayMsgErro['EMAIL_ERRO_FORMATO'] = "Este e-mail está com incorreto!";

        $this->obterAlerta( base64_decode( $msg ) );
    }

    /**
     * 
     * @param unknown_type $msg
     * @param unknown_type $cor
     * @return string
     */
    private function desenharHtml($texto, $tipo)
    {
        return '<div class="' . self::CLASSE_CSS . ' ' . $tipo . '" align="center">' . $texto . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    }

    /**
     * 
     * @param unknown_type $msg
     */
    private function obterAlerta($msg)
    {
        $arrayErroKeys = array_keys($this->arrayMsgErro);
        $arrayOkKeys = array_keys($this->arrayMsgOk);

        if (in_array($msg, $arrayErroKeys))
        {
            echo $this->desenharHtml($this->arrayMsgErro[$msg], 'alert-danger');
        }
        else if (in_array($msg, $arrayOkKeys))
        {
            echo $this->desenharHtml($this->arrayMsgOk[$msg], 'alert-success');
        }
        else
        {
            echo $this->desenharHtml(' -- ', '#666');
            
        }
    }

}
?>

