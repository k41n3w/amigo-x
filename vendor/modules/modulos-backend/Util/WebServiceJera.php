<?php

namespace Util;

use Configuration\Configuration;

final class WebServiceJera
{
    private $strUrl;

    private $strAutenticacao;

    private $strTabela;

    private $arrParametrosUrl;

    private $arrData;

    /**
     * Recupera a url do web service e inicializa os arrays
     */
    public function __construct()
    {
        $this->strUrl = $this->getUrl();

        $this->arrData = [];
        $this->arrParametrosUrl = [];
    }

    /**
     * Informa qual o nome da tabela a ser feita a requisicao
     * @param string $strTabela nome da tabela
     */
    public function setTabela($strTabela)
    {
        $this->strTabela = $strTabela;
    }

    /**
     * Informa o usuario e a hash de sua senha para autenticacao
     * @param string $strUsuario nome de usuario do Jera
     * @param string $strHash    hash da senha
     */
    public function setAutenticacao($strUsuario, $strHash)
    {
        $this->strAutenticacao = "username=$strUsuario&hash=$strHash";
    }

    /**
     * Seta os parametros a serem inseridos na url
     * @param array $arrParametrosUrl array com os parametros
     */
    public function setParametrosUrl(array $arrParametrosUrl)
    {
        $this->arrParametrosUrl = $arrParametrosUrl;
    }

    /**
     * Seta os dados a serem enviados na requisicao
     * @param array $arrData array com os dados
     */
    public function setData(array $arrData)
    {
        $this->arrData = $arrData;
    }

    /**
     * Realiza uma requisicao do tipo GET
     * @return array array contendo o resultado da requisicao
     */
    public function get()
    {
        return $this->executaRequisicao('GET');
    }

    /**
     * Realiza uma requisicao do tipo POST
     * @return array array contendo o resultado da requisicao
     */
    public function post()
    {
        return $this->executaRequisicao('POST');
    }

    /**
     * Realiza uma requisicao do tipo PUT
     * @return array array contendo o resultado da requisicao
     */
    public function put()
    {
        return $this->executaRequisicao('PUT');
    }

    /**
     * Retorna o endereco de onde se encontra os web services do Jera
     *
     * @SuppressWarnings(PHPMD)
     *
     * @return string string com o ip e porta do web service
     */
    private function getUrl()
    {
        $arrWsJera = Configuration::read('webservicesjera');
        return 'http://'.$arrWsJera['ip'].'/'.$arrWsJera['provedor'].'/';
    }

    private function addParametrosUrl(array $arrayParametrosUrl)
    {
        foreach ($arrayParametrosUrl as $key => $value) {
            $this->strUrl.= "&$key=$value";
        }
    }

    /**
     * Envia uma requisicao http usando a biblioteca curl para os web services do Jera
     *
     * @param  string $strTabela nome da tabela a ser consultada
     * @param  string $strTipo   tipo da requisicao: PUT, POST ou GET
     * @param  array  $arrData   array com os dados a serem enviados na requisicao
     *
     * @return array             um array com o resultado da requisicao
     */
    private function executaRequisicao(string $strTipo)
    {
        if (!in_array('curl', get_loaded_extensions())) {
            return [
                'code' => 0,
                'erro' => 'É necessário ter a extensão CURL habilitada no servidor.'
            ];
        }

        $this->strUrl.= $this->strTabela.'?'.$this->strAutenticacao;
        if (count($this->arrParametrosUrl) > 0) {
            $this->addParametrosUrl($this->arrParametrosUrl);
        }

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->strUrl);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $strTipo);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        if (count($this->arrData) > 0) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($this->arrData));
        }

        $resultado = curl_exec($curl);
        $erroNumero = curl_errno($curl);
        $mensagemErro = curl_error($curl);

        curl_close($curl);

        // Volta configuração da URL para casos de duas chamadas no para o mesmo objeto.
        // (Ex. Manipulação da 'AgendaItens' e os Status.)
        $this->strUrl = $this->getUrl();

        if ($resultado === false) {
            return [
                'code' => 0,
                'message' => "Erro $erroNumero: $mensagemErro"
            ];
        }
        // trata a mensagem de erro vinda do Jera caso exista
        $arrayResultado = json_decode($resultado, true);
        if (array_key_exists('tipo', $arrayResultado)) {
            if ($arrayResultado['tipo'] === 'exception') {
                return [
                    'code' => 0,
                    'message' => $arrayResultado['msg']
                ];
            }
        }

        return [
            'code' => 1,
            'resultado' => $resultado
        ];
    }
}
