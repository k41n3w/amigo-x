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
        global $grupo;
        // Verifica se já existe se ja existe o usuario cadastrado no sistema.
        $grupo = $this->select(QueryBuilder::select('Groups_in', [], ['idgroup' => '']), ['idgroup' => $arrDadosSorteio['idgroup']]);
        if (!$grupo) {
            return Retorno::erro('Usuario Origem não cadastrado no sistema.');
        }

        foreach($grupo AS $participante) {
            if(count($grupo) > 1) {
        		srand((float) microtime() * 10000000);
        		$sorteado = array_rand($grupo);
        		if($grupo[ $sorteado ]['iduser'] != $participante['iduser']) {
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

        return 'oi';
        // Salva no banco de dados.
        $salvaSorteio = $this->execute(QueryBuilder::insert('Mensages', $arrDadosSorteio), $arrDadosSorteio);

        if ($salvaSorteio) {
            return Retorno::sucesso('Sorteio cadastrada com sucesso.');
        }else{
            return Retorno::erro('Algo de errado aconteceu no cadastro, contate o administrador do sistema.');
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
