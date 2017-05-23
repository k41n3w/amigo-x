<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;
use DateTime;

class Mensagem extends AppModel
{
    /**
     * Método utilizado para cadastrar um mensagem na base de dados.
     *
     * @param  [Array]  $arrDadosMensagem Array de informações do mensagem.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar mensagem.
     */
    public function cadastrar($arrDadosMensagem)
    {
        // Verifica se já existe se ja existe o usuario cadastrado no sistema.
        $Usuario = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $arrDadosMensagem['userorigin']]);
        if (!$Usuario) {
            return Retorno::erro('Usuario Origem não cadastrado no sistema.');
        }

        // Verifica se já existe se ja existe o usuario cadastrado no sistema.
        $Usuario = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $arrDadosMensagem['userreciver']]);
        if (!$Usuario) {
            return Retorno::erro('Usuario Destino não cadastrado no sistema.');
        }

        if (strlen($arrDadosMensagem['mensage']) > 255) {
            return Retorno::erro('Mensagem só pode conter, no máximo, 255 caracteres.');
        }

        $now = new DateTime();
        $now = date("Y-m-d H:m");
        $arrDadosMensagem['datetime'] = $now;

        //return $arrDadosMensagem;
        // Salva no banco de dados.
        $salvaMensagem = $this->execute(QueryBuilder::insert('Mensages', $arrDadosMensagem), $arrDadosMensagem);

        if ($salvaMensagem) {
            return Retorno::sucesso('Mensagem cadastrada com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }

    }

    /**
     * Método responsável por listar os mensagems cadastrados no banco de dados.
     *
     * @param  [Integer] $idMensagem ID do mensagem (Opcional)
     * @return [Array]              Lista de mensagems.
     */
    public function listar($pesquisaMensagem = null)
    {
        if ($pesquisaMensagem) {
            $sql = "SELECT * FROM Mensages
                        WHERE userorigin = :userorigin
                        AND userreciver = :userreciver";

        $mensagem = $this->executeSQL($sql, [':userorigin' => $pesquisaMensagem['userorigin'], ':userreciver' => $pesquisaMensagem['userreciver']]);
        if ($mensagem) {
                return Retorno::sucesso($mensagem);
            }else{
                return Retorno::erro('Mensagens nao encontrado.');
            }
        }
    }

}
