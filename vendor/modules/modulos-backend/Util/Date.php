<?php

namespace Util;

use \DateTime;

class Date {
    /**
    * Método que converte uma data no Unix para o formato d/m/Y
    * @param  int $date data no formato Unix
    * @return string    data no formato d/m/Y
    */
    public static function parseDate($date)
    {
        $begin = '01/01/1970';
        $newDate = $date - 25569;
        $strData = "+$newDate days";
        return date('d/m/Y', strtotime("$strData", strtotime($begin)));
    }

    /**
    * Método que converte uma data do padrão ISO para o brasileiro
    * @param  int $date no formato ISO ou brasileiro
    * @return string    data no formato d/m/Y ou y-m-d
    */
    public static function converteData($data)
    {
        if ( ! strstr( $data, '/' ) )
        {
            // $data está no formato ISO (yyyy-mm-dd) e deve ser convertida
            // para dd/mm/yyyy
            sscanf( $data, '%d-%d-%d', $y, $m, $d );
            return sprintf( '%d/%d/%d', $d, $m, $y );
        }
        else
        {
            // $data está no formato brasileiro e deve ser convertida para ISO
            sscanf( $data, '%d/%d/%d', $d, $m, $y );
            return sprintf( '%d-%d-%d', $y, $m, $d );
        }
        return false;
    }

    /**
    * Método que compara duas datas
    * @param  int $date1 data no formato de date ou string brasileiro ou americano
    * @param  int $date2 data no formato de date ou string brasileiro ou americano
    * @param  int $opcao string com o tipo de comparação que deseja realizar
    * @return boolean true or false
    */
    public static function comparaData($data1, $data2, $opcao)
    {
        if ( ! strstr( $data, '/' ) ){
            $data1 = converteData($data1);
            $data2 = converteData($data2);
        }
        $data1 = new DateTime($data1);
        $data2 = new DateTime($data2);
        if ($opcao === '=')
        {
            return $data1 == $data2;
        }
        elseif($opcao === '>')
        {
            return $data1 > $data2;
        }
        elseif($opcao === '<'){
            return $data1 < $data2;
        }
    }

    /**
    * Método que retorna o intervalo de datas
    * @param  int $date1 data no formato de date ou string brasileiro ou americano
    * @param  int $date2 data no formato de date ou string brasileiro ou americano
    * @return string com o número de dias
    */
    public static function intervaloData($data1, $data2){
        if ( ! strstr( $data, '/' ) ){
            $data1 = converteData($data1);
            $data2 = converteData($data2);
        }
        $data1 = new DateTime($data1);
        $data2 = new Datetime($data2);
        $intervalo = $data1->diff(data2);
        return $intervalo->format('%R%a');
    }

    /**
     * Método que verifica se uma data é valida.
     *
     * @param string $data   Data informada.
     * @param string $fotmato Formato de comparação da data.
     */
    public static function validaData($data, $fotmato = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($fotmato, $data);
        return $d && $d->format($fotmato) == $data;
    }

}
