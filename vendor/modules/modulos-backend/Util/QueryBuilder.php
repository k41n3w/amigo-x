<?php

namespace Util;

final class QueryBuilder
{
    /**
     * Monta a clausula WHERE de uma consulta ao banco de dados
     * @param  [Array]  $arrWhere array associativo com as colunas e valores
     * @return [String]           uma string o sql
     */
     private static function obtemClausulaWhere(array $arrWhere)
     {
         //pega a primeira chave do array
         $strChave = implode('', array_keys(array_slice($arrWhere, 0, 1)));
         //monta o where usando o array_walk
         $strWhere = '';
         array_walk($arrWhere, function ($valor, $chave) use ($strChave, &$strWhere) {
             if ($chave === $strChave) {
                 if (!is_null($valor)) {
                    $strWhere .= "WHERE $chave = :$chave ";
                    return;
                 }
                 $strWhere .= "WHERE $chave IS NULL ";
                 return;
             }
             if (!is_null($valor)) {
                $strWhere .= "AND $chave = :$chave ";
                return;
             }
             $strWhere .= "AND $chave IS NULL ";
         });
         return $strWhere;
     }

    /**
     * Função que monta uma query do tipo 'SELECT'.
     *
     * @param  [String] $strTabela Nome da tabela.
     * @param  [Array]  $arrCampos  Array de Campos e Valores que será passado como
     *                              parâmetro. O utilizado aqui é o valor chave do
     *                              Array. (Opcional)
     * @param  [Array]  $arrWhere   Array de Campos e Valores do WHERE. (Opcional)
     *
     * @return [String]             Retorna a String SQL.
     */
    public static function select($strTabela, $arrCampos = null, $arrWhere = null)
    {
        $strSql = 'SELECT ';
        $strSql.= (empty($arrCampos)) ? ' * ' : implode(', ', $arrCampos);
        $strSql.= ' FROM '.$strTabela.' ';

        if (!empty($arrWhere)) {
            $strSql.= self::obtemClausulaWhere($arrWhere);
        }

        return $strSql;
    }

    /**
     * Função que monta uma query do tipo 'INSERT'.
     *
     * @param  [String] $strTabela Nome da tabela.
     * @param  [Array]  $arrCampos  Array de Campos e Valores que será passado como
     *                              parâmetro. O utilizado aqui é o valor chave do
     *                              Array.
     *
     * @return [String]             Retorna a String SQL.
     */
    public static function insert($strTabela, $arrCamposValores)
    {
        $arrColunas = array_keys($arrCamposValores);
        $arrParametros = array_map(function ($valor) {
            return ':'.$valor;
        }, $arrColunas);

        return "INSERT INTO $strTabela (".implode(', ', $arrColunas).") VALUES (".implode(', ', $arrParametros).")";
    }

    /**
     * Função que monta uma query do tipo 'UPDATE'.
     *
     * @param  [String] $strTabela Nome da tabela.
     * @param  [Array]  $arrCampos  Array de Campos e Valores que será passado como
     *                              parâmetro. O utilizado aqui é o valor chave do
     *                              Array.
     * @param  [Array]  $arrWhere   Array de Campos e Valores do WHERE.
     *
     * @return [String]             Retorna a String SQL.
     */
    public static function update($strTabela, $arrCamposValores, $arrWhere)
    {
        $strSql = "UPDATE $strTabela SET ";

        $arrCampos = array_map(function ($valor) {
            return $valor.' = :'.$valor;
        }, array_keys($arrCamposValores));

        $strSql .= implode(', ', $arrCampos). ' ';

        if (!empty($arrWhere)) {
            $strSql .= self::obtemClausulaWhere($arrWhere);
        }

        return $strSql;
    }

    /**
     * Função que monta uma query do tipo 'DELETE'.
     *
     * @param  [String] $strTabela Nome da tabela.
     * @param  [Array]  $arrWhere   Array de Campos e Valores do WHERE.
     *
     * @return [String]             Retorna a String SQL.
     */
    public static function delete($strTabela, $arrWhere)
    {
        return "DELETE FROM $strTabela ".self::obtemClausulaWhere($arrWhere);
    }
}
