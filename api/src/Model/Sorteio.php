<?php

namespace Model;

use PDO;
use Util\JWTAuth;
use Util\QueryBuilder;
use Util\Retorno;
use DateTime;

class Sorteio extends AppModel
{
    /**
     * Método utilizado para cadastrar um sorteio na base de dados.
     *
     * @param  [Array]  $arrDadosSorteio Array de informações do sorteio.
     *
     * @return [Array]  Sorteio de erro ou sucesso ao cadastrar sorteio.
     */
    public function sorteio($arrDadosSorteio)
    {
        // Verifica se existem pessoas associadas ao grupo que sejam suficiente para fazer a brincadeira
        $grupo = $this->select(QueryBuilder::select('Groups_in', [], ['idgroup' => '']), ['idgroup' => $arrDadosSorteio['idgroup']]);
        $qtdPessoasGrupo = count($grupo);
        if ($qtdPessoasGrupo < 2) {
            return Retorno::erro('Quantidade de pessoas insuficiente para realizar sorteio.');
        }

        $sorteio = [];
        do {
            $numSorteio = count($grupo);
            $random = rand(0,($numSorteio));
            if ($grupo[$random] != null) {
                array_push($sorteio, $grupo[$random]);
                unset($grupo[$random]);
            }
        } while (count($sorteio) < ($qtdPessoasGrupo - 1));
        foreach ($grupo as $key => $value) {
            array_push($sorteio, $value);
        }

        $salva = [];
        foreach ($sorteio as $key => $value) {
            $salva[$key] = [
                'idgroup' => $value['idgroup'],
                'iduserorigin' => $value['iduser'],
                'iduserdestination' => $sorteio[$key+1]['iduser']
            ];
        }

        $ultimoUser = count($salva);
        $salva[$ultimoUser - 1]['iduserdestination'] = $sorteio[0]['iduser'];

        foreach ($salva as $key => $value) {
            $salvaSorteio = $this->execute(QueryBuilder::insert('Lottery_relation', $value), $value);
            if (!$salvaSorteio) {
                return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
            }
        }

        $sql = "UPDATE Grupo SET finalized = 1 WHERE idgroup = :idgroup";

        $sorteio = $this->execute($sql, [':idgroup' => $arrDadosSorteio['idgroup']]);

        if ($sorteio) {
            return Retorno::sucesso('Sorteio realizado com sucesso');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.1');
        }
    }

    /**
     * Método responsável por listar os sorteios cadastrados no banco de dados.
     *
     * @param  [Integer] $idSorteio ID do sorteio (Opcional)
     * @return [Array]              Lista de sorteios.
     */
    public function listar($pesquisaSorteio = null)
    {
        if ($pesquisaSorteio) {
            $sql = "SELECT * FROM Mensages
                        WHERE userorigin = :userorigin
                        AND userreciver = :userreciver";

        $sorteio = $this->executeSQL($sql, [':userorigin' => $pesquisaSorteio['userorigin'], ':userreciver' => $pesquisaSorteio['userreciver']]);
        if ($sorteio) {
                return Retorno::sucesso($sorteio);
            }else{
                return Retorno::erro('Mensagens nao encontrado.');
            }
        }
    }

    /**
     * Método responsável por listar os sorteios cadastrados no banco de dados.
     *
     * @param  [Integer] $idSorteio ID do sorteio (Opcional)
     * @return [Array]              Lista de sorteios.
     */
    public function listarGrupoSorteio($pesquisaSorteio = null)
    {
        $sql = "SELECT * FROM Lottery_relation
                        WHERE idgroup = idgroup";

        $sorteio = $this->executeSQL($sql, [':idgroup' => $pesquisaSorteio['idgroup']]);
        $brincadeira = [];
        foreach ($sorteio as $key => $value) {
            $origem = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $value['iduserorigin']]);
            $destino = $this->select(QueryBuilder::select('User', [], ['iduser' => '']), ['iduser' => $value['iduserdestination']]);
            $arrAux = [
                'origem' => $origem[0]['name'],
                'destino' => $destino[0]['name']
            ];
            array_push($brincadeira, $arrAux);
        }
        if ($brincadeira) {
                return Retorno::sucesso($brincadeira);
            }else{
                return Retorno::erro('Mensagens nao encontrado.');
        }
    }

    public function Sortear($id = 0) {
  global $grupo;
  if(count($grupo) > 1) {
    srand((float) microtime() * 10000000);
    $sorteado = array_rand($grupo);
    if($grupo[ $sorteado ]['iduser'] != $id) {
      $escolhido = $nomes[ $sorteado ];
      unset($grupo[ $sorteado ]);
      return $escolhido;
    }
    else {
      return sorteio($id);
    }
  }
  else {
    foreach ($grupo as $grupo) {
      return $grupo;
    }
  }
} 

}
