<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Groups_in extends AppModel
{
    /**
     * Método utilizado para cadastrar um grupo na base de dados.
     *
     * @param  [Array]  $arrDadosGrupo Array de informações do grupo.
     *
     * @return [Array]  Mensagem de erro ou sucesso ao cadastrar grupo.
     */
    public function cadastrar($arrDadosGrupo, $idUser)
    {
        // Verifica se já existe se ja existe o grupo cadastrado no sistema.
        $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['idgroup' => '']), ['idgroup' => $arrDadosGrupo['idgroup']]);
        if (!$Grupo) {
            return Retorno::erro('Grupo não cadastrado no sistema.');
        }

        $arrDadosGrupo = [
            'idgroup' => $arrDadosGrupo['idgroup'],
            'iduser' => $idUser
        ];

        // Salva no banco de dados.
        $salvaGrupo = $this->execute(QueryBuilder::insert('Groups_in', $arrDadosGrupo), $arrDadosGrupo);
        if ($salvaGrupo) {
            return Retorno::sucesso('Usuario inserido ao grupo com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
        }
    }

    /**
     * Método responsável por listar os grupos cadastrados no banco de dados.
     *
     * @param  [Integer] $idGrupo ID do grupo (Opcional)
     * @return [Array]              Lista de grupos.
     */
    public function listar($pesquisaGrupo = null)
    {
        $Grupo = $this->select(QueryBuilder::select('Groups_in', [], ['idgroup' => '']), ['idgroup' => $pesquisaGrupo['idgroup']]);
        if ($Grupo) {
            return Retorno::sucesso($Grupo);
        }else{
            return Retorno::erro('Grupo nao encontrado.');
        }
    }

    /**
     * Método responsável por listar os grupos cadastrados no banco de dados.
     *
     * @param  [Integer] $idGrupo ID do grupo (Opcional)
     * @return [Array]              Lista de grupos.
     */
    public function listarUsuariosGrupo($pesquisaGrupo = null)
    {
        $Grupo = $this->select(QueryBuilder::select('Groups_in', [], ['iduser' => '']), ['iduser' => $pesquisaGrupo['iduser']]);
        if ($Grupo) {
            return Retorno::sucesso($Grupo);
        }else{
            return Retorno::erro('Pesquisa não retornou dados.');
        }
    }
    //
    // /**
    //  * Método responsável por alterar os dados de um grupo no banco de dados.
    //  *
    //  * @param  [Integer] $idGrupo     ID do grupo que receberá as alterações.
    //  * @param  [Array]   $arrAlteracoes Dados de alteração do grupo.
    //  * @return [Array]                  Mensagem de sucesso
    //  */
    // public function alterar($idGrupo, array $arrAlteracoes)
    // {
    //     if (!$idGrupo) {
    //         return Retorno::erro('Favor informar o id do grupo a ser alterado.');
    //     }
    //
    //     // Verifica se já existe se ja existe o grupo cadastrado no sistema.
    //     $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['idgroup' => '']), ['idgroup' => $idGrupo]);
    //     if (!$Grupo) {
    //         return Retorno::erro('Grupo nao cadastrado no sistema.');
    //     }
    //
    //     if (strlen($arrAlteracoes['name']) > 255) {
    //         return Retorno::erro('O nome de grupo só pode conter até de 255 caracteres.');
    //     }
    //
    //     // Verifica se já existe se ja existe o nome do grupo cadastrado no sistema.
    //     $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['name' => '']), ['name' => $arrAlteracoes['name']]);
    //     if ($Grupo) {
    //         if ($Grupo[0]['name'] != $arrAlteracoes['name']) {
    //             return Retorno::erro('Nome do grupo ' . $arrAlteracoes['name'] . ' já cadastrado no sistema.');
    //         }
    //     }
    //
    //     // Atualiza no banco de dados.
    //     $arrWhere = ['idgroup' => $idGrupo];
    //     $arrParametros = array_merge($arrAlteracoes, $arrWhere);
    //     $salvaGrupo = $this->execute(QueryBuilder::update('Grupo', $arrAlteracoes, $arrWhere), $arrParametros);
    //
    //     if ($salvaGrupo) {
    //         return Retorno::sucesso('Grupo alterado com sucesso.');
    //     }else{
    //         return Retorno::erro('Algo de errado aconteceu na alteracao, contate o administrador do sistema.');
    //     }
    // }
}
