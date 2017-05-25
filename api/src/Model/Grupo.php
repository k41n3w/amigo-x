<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;

class Grupo extends AppModel
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
        if (strlen($arrDadosGrupo['name']) > 255) {
            return Retorno::erro('O nome de grupo só pode conter até de 255 caracteres.');
        }

        // Verifica se já existe se ja existe o grupo cadastrado no sistema.
        $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['name' => '']), ['name' => $arrDadosGrupo['name']]);
        if ($Grupo) {
            return Retorno::erro('Grupo: ' . $arrDadosGrupo['name'] . ' já cadastrado no sistema.');
        }

        $arrDadosGrupoInsert = [
            'name'=> $arrDadosGrupo['name'],
            'owner'=> $idUser,
            'finalized' => 0
        ];
        // Salva no banco de dados.
        $salvaGrupo = $this->execute(QueryBuilder::insert('Grupo', $arrDadosGrupoInsert), $arrDadosGrupoInsert);
        if ($salvaGrupo) {

            $salvaGrupo = $this->getConnection();
            $idGrupo = $salvaGrupo->lastInsertId();

            $arrDadosGrupo_inInsert = [
                'idgroup'=>$idGrupo,
                'iduser'=> $idUser,
            ];
            $salvaGrupo = $this->execute(QueryBuilder::insert('Groups_in', $arrDadosGrupo_inInsert), $arrDadosGrupo_inInsert);
            if ($salvaGrupo) {
                return Retorno::sucesso('Grupo cadastrado com sucesso.');
            }else{
                return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
            }
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
    public function listar($pesquisaGrupo = null, $iduser)
    {
        if ($pesquisaGrupo['name'] !== '') {
            $pesquisaGrupo['name'] = '%'.$pesquisaGrupo['name'].'%';

            $sql = "select g.idgroup, g.name
                    from Grupo as g
                    where g.idgroup
                    not IN (
                        select
                        distinct gin.idgroup
                        from Groups_in as gin
                        where gin.iduser = :iduser)
                    AND g.name LIKE :name";

            $Grupo = $this->executeSQL($sql, [':name' => $pesquisaGrupo['name'], ':iduser' => $iduser]);
            if ($Grupo) {
                return Retorno::sucesso($Grupo);
            }else{
                return Retorno::erro('Grupo nao encontrado.');
            }
        }
        $sql = "select g.idgroup, g.name
                from Grupo as g
                where g.idgroup
                not IN (
                    select
                    distinct gin.idgroup
                    from Groups_in as gin
                    where gin.iduser = :iduser)";

        $Grupo = $this->executeSQL($sql, [':iduser' => $iduser]);
        if ($Grupo) {
            return Retorno::sucesso($Grupo);
        }else{
            return Retorno::erro('Nenhum Grupo encontrado.');
        }
    }

    /**
     * Método responsável por listar os grupos cadastrados no banco de dados.
     *
     * @param  [Integer] $idGrupo ID do grupo (Opcional)
     * @return [Array]              Lista de grupos.
     */
    public function listarDashboard($pesquisaGrupo = null, $iduser)
    {
      if ($pesquisaGrupo['tipo'] == 1) {
          if ($pesquisaGrupo['name'] !== '') {
                $pesquisaGrupo['name'] = '%'.$pesquisaGrupo['name'].'%';

                $sql = "SELECT * FROM Grupo
                            WHERE owner = :iduser
                            AND name LIKE :name";

                $Grupo = $this->executeSQL($sql, [':name' => $pesquisaGrupo['name'], ':iduser' => $iduser]);
                if ($Grupo) {
                    return Retorno::sucesso($Grupo);
                }else{
                    return Retorno::erro('Grupo nao encontrado.');
                }
          }else{
            $sql = "SELECT * FROM Grupo
                        WHERE owner = :iduser";

            $Grupo = $this->executeSQL($sql, [':iduser' => $iduser]);
            if ($Grupo) {
                return Retorno::sucesso($Grupo);
            }else{
                return Retorno::erro('Grupo nao encontrado.');
            }
          }
      }else{

          $sql = "SELECT grupo.idgroup, grupo.name
                  FROM grupo
                  INNER JOIN groups_in
                  WHERE groups_in.iduser = :iduser
                  group by  grupo.idgroup, grupo.name";

          $Grupo = $this->executeSQL($sql, [':iduser' => $iduser]);
          if ($Grupo) {
              return Retorno::sucesso($Grupo);
          }else{
              return Retorno::erro('Grupo nao encontrado.');
          }
        }
    }

    /**
     * Método responsável por alterar os dados de um grupo no banco de dados.
     *
     * @param  [Integer] $idGrupo     ID do grupo que receberá as alterações.
     * @param  [Array]   $arrAlteracoes Dados de alteração do grupo.
     * @return [Array]                  Mensagem de sucesso
     */
    public function alterar($idGrupo, array $arrAlteracoes)
    {
        if (!$idGrupo) {
            return Retorno::erro('Favor informar o id do grupo a ser alterado.');
        }

        // Verifica se já existe se ja existe o grupo cadastrado no sistema.
        $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['idgroup' => '']), ['idgroup' => $idGrupo]);
        if (!$Grupo) {
            return Retorno::erro('Grupo nao cadastrado no sistema.');
        }

        if (strlen($arrAlteracoes['name']) > 255) {
            return Retorno::erro('O nome de grupo só pode conter até de 255 caracteres.');
        }

        // Verifica se já existe se ja existe o nome do grupo cadastrado no sistema.
        $Grupo = $this->select(QueryBuilder::select('Grupo', [], ['name' => '']), ['name' => $arrAlteracoes['name']]);
        if ($Grupo) {
            if ($Grupo[0]['name'] != $arrAlteracoes['name']) {
                return Retorno::erro('Nome do grupo ' . $arrAlteracoes['name'] . ' já cadastrado no sistema.');
            }
        }

        // Atualiza no banco de dados.
        $arrWhere = ['idgroup' => $idGrupo];
        $arrParametros = array_merge($arrAlteracoes, $arrWhere);
        $salvaGrupo = $this->execute(QueryBuilder::update('Grupo', $arrAlteracoes, $arrWhere), $arrParametros);

        if ($salvaGrupo) {
            return Retorno::sucesso('Grupo alterado com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu na alteracao, contate o administrador do sistema.');
        }
    }
}
