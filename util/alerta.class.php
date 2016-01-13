<?php

/**
 * Enter description here ...
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
        $this->arrayMsgOk['EMAIL_REDEFINIR_SENHA'] = 'E-mail enviado!<br/>Por favor, confira seu e-mail e leia as instruções para redefinir sua senha.';

        // Mensagens de Erro
        $this->arrayMsgErro['OPERACAO_ERRO'] = "Erro ao executar a operacao!";
        $this->arrayMsgErro['ERRO_DELETAR_MODULO'] = "Este módulo está sendo utilizado por um ou mais cursos!";
        $this->arrayMsgErro['EXCLUIR_REGISTRO_REL'] = 'Não foi possível excluir este registro, porque ele está sendo utilizado!';
        $this->arrayMsgErro['REL_EXISTENTE'] = "Este(s) relacionamento(s) já existe(m) no banco de dados!";
        $this->arrayMsgErro['LOGIN_INCORRETO'] = "Dados incorretos!";
        $this->arrayMsgErro['EMAIL_NAO_ENCONTRADO'] = 'O e-mail passado não foi encontrado no banco de dados!';
        $this->arrayMsgErro['LOGIN_ERRO'] = "Erro ao executar a operacao! Login a ser cadastrado já existe no banco de dados!";

        $this->obterAlerta($msg);
    }

    /**
     * Enter description here ...
     * @param unknown_type $msg
     * @param unknown_type $cor
     * @return string
     */
    private function desenharHtml($texto, $tipo)
    {
        return '<div class="' . self::CLASSE_CSS . ' ' . $tipo . '" align="center">' . $texto . '<button type="button" class="close" data-dismiss="alert">&times;</button></div>';
    }

    /**
     * Enter description here ...
     * @param unknown_type $msg
     */
    private function obterAlerta($msg)
    {
        $arrayErroKeys = array_keys($this->arrayMsgErro);
        $arrayOkKeys = array_keys($this->arrayMsgOk);

        if (in_array($msg, $arrayErroKeys))
        {
            echo $this->desenharHtml($this->arrayMsgErro[$msg], 'alert-error');
        } else if (in_array($msg, $arrayOkKeys))
        {
            echo $this->desenharHtml($this->arrayMsgOk[$msg], 'alert-success');
        } else
        {
            echo $this->desenharHtml(' -- ', '#666');
            
        }
    }

}
?>

