<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Usuario extends AppModel
{

    /**
     * Método utilizado para realizar o login do usuário no sistema.
     *
     * @param  [String] $strLogin Login do usuário
     * @param  [String] $strSenha Senha do usuário
     *
     * @return [Array]  Informações de login do usuário
     */
    public function login($strLogin, $strSenha)
    {

        $arrParametros = [
            'login' => $strLogin
        ];

        $arrUsuario = $this->select(QueryBuilder::select('User', [], $arrParametros), $arrParametros);
        if (!empty($arrUsuario)) {
            $arrUsuario = $arrUsuario[0];
            if (password_verify($strSenha, $arrUsuario['password'])) {
                $arrParametros = [
                    'iduserorigin' => $arrUsuario['iduser']
                ];
                $arrMensagens = $this->select(QueryBuilder::select('Lottery_relation', [], $arrParametros), $arrParametros);
                $token = array (
                'dataHoraCriacao' => time(),
                'dadosUsuario' => array(
                        'userId' => $arrUsuario['iduser'],
                        'userName' => $arrUsuario['name']
                    )
                );
                $token = JWTAuth::encode($token, 'cJRJ1slFUJhsN1worFmPaCxLAPxgIQdi4yIXQKlv4UTo0urdWLr3iHjaAgWH1dbBNRgBhRkDfMXY5v5xUIsi/w==', 'HS256');

                /*         * Retorna o JWT codificado para o cliente         */
                $retorno = array (
                    'token' => $token,
                    'userId' => $arrUsuario['iduser'],
                    'userNome' => $arrUsuario['name'],
                    'gruposMensagens' => $arrMensagens,
                );
                return Retorno::sucesso($retorno);
            }
            return Retorno::erro('Senha incorreta.');
        }
        return Retorno::erro('Usuário não encontrado.');
    }

    /**
     * Método utilizado para cadastrar um usuário na base de dados.
     *
     * @param  [Array]  $arrDadosUsuario Array de informações do usuário.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar usuário.
     */
    public function cadastrar($arrDadosUsuario)
    {
        if (strlen($arrDadosUsuario['name']) > 255) {
            return Retorno::erro('O nome de usuário só pode conter até de 255 caracteres.');
        }

        // Verifica se já existe se ja existe o usuário cadastrado no sistema.
        $usuario = $this->select(QueryBuilder::select('User', [], ['login' => '']), ['login' => $arrDadosUsuario['login']]);
        if ($usuario) {
            return Retorno::erro('Login ' . $arrDadosUsuario['login'] . ' já cadastrado no sistema.');
        }

        // Criptografa o campo senha
        $arrDadosUsuario['password'] = password_hash($arrDadosUsuario['password'], PASSWORD_DEFAULT);

        // Salva no banco de dados.
        $salvaUsuario = $this->execute(QueryBuilder::insert('User', $arrDadosUsuario), $arrDadosUsuario);

        if ($salvaUsuario) {
            return Retorno::sucesso('Usuário cadastrado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os usuários cadastrados no banco de dados.
     *
     * @param  [Integer] $idUsuario ID do usuário (Opcional)
     * @return [Array]              Lista de usuários.
     */
    public function listar($pesquisaUsuario = null)
    {
        if ($pesquisaUsuario) {
            $usuario = $this->select(QueryBuilder::select('User', [], ['login' => '']), ['login' => $pesquisaUsuario['login']]);
            if ($usuario) {
                return Retorno::sucesso($usuario);
            }else{
                return Retorno::erro('Usuario nao encontrado.');
            }
        }
        $sql = "SELECT * FROM User;";

        $usuario = $this->executeSQL($sql, []);
        if ($usuario) {
            return Retorno::sucesso($usuario);
        }else{
            return Retorno::erro('Nenhum usuario encontrado.');
        }
    }

    /**
     * Método responsável por alterar os dados de um usuário no banco de dados.
     *
     * @param  [Integer] $idUsuario     ID do usuário que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do usuário.
     * @return [Array]                  Mensagem de sucesso
     */
    public function alterar($idUsuario, array $arrAlteracoes)
    {
        if (!$idUsuario) {
            return Retorno::erro('Favor informar o id do usuário a ser alterado.');
        }

        // Verifica se já existe se ja existe o usuário cadastrado no sistema.
        $usuario = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $idUsuario]);
        if (!$usuario) {
            return Retorno::erro('Usuario nao cadastrado no sistema.');
        }

        if (strlen($arrAlteracoes['name']) > 255) {
            return Retorno::erro('O nome de usuário só pode conter até de 255 caracteres.');
        }

        // Verifica se já existe se ja existe o login cadastrado no sistema.
        $usuario = $this->select(QueryBuilder::select('User', [], ['login' => '']), ['login' => $arrAlteracoes['login']]);
        if ($usuario) {
            if ($usuario[0]['login'] != $arrAlteracoes['login']) {
                return Retorno::erro('Login ' . $arrAlteracoes['login'] . ' já cadastrado no sistema.');
            }
        }

        // Verifica se já existe o campo password no array de alterações
        if (array_key_exists("password", $arrAlteracoes)) {
            // Criptografa o campo senha
            $arrAlteracoes['password'] = password_hash($arrAlteracoes['password'], PASSWORD_DEFAULT);
        }

        // Atualiza no banco de dados.
        $arrWhere = ['iduser' => $idUsuario];
        $arrParametros = array_merge($arrAlteracoes, $arrWhere);
        $salvaUsuario = $this->execute(QueryBuilder::update('User', $arrAlteracoes, $arrWhere), $arrParametros);

        if ($salvaUsuario) {
            return Retorno::sucesso('Usuário alterado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu na alteracao, contate o administrador do sistema.');
        }
    }

    public function alterarSenha($idUsuario, $arrAlteracoes)
    {
        $usuario = $this->select(QueryBuilder::select('User', [], ['iduser' => $idUsuario]), ['iduser' => $idUsuario]);
        if ($usuario == false) {
            return Retorno::erro('Usuario inexistente no sistema.');
        }

        if (!password_verify($arrAlteracoes['senhaantiga'], $usuario[0]['password'])) {
            return Retorno::erro('A senha antiga está incorreta.');
        }
        if (password_verify($arrAlteracoes['senhanova'], $usuario[0]['password'])) {
            return Retorno::erro('A senha antiga e a nova são iguais.');
        }

        $arrWhere = [
            'iduser' => $idUsuario
        ];
        $arrSenha = [
            "password" => password_hash($arrAlteracoes['senhanova'], PASSWORD_DEFAULT)
        ];

        $arrParametros = array_merge($arrSenha, $arrWhere);

        $this->execute(QueryBuilder::update('User', $arrSenha, $arrWhere), $arrParametros);

        return Retorno::sucesso('Senha alterada com sucesso.');
    }
}
