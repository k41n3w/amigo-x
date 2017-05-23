<?php

    public function buscarCep($cep)
    {
        //chama função para tratar o cep recebido
        $dadosRetorno = $this->trataCep($cep);
        if($dadosRetorno['codigo'] == 0)
        {
            return $dadosRetorno;
        }
        $cep = $dadosRetorno['retorno'];

        //chamada da primeira Url...
        $url = "http://viacep.com.br/ws/".$cep."/json/";

        $curl = curl_init($url);                            //Inicializa uma nova sessão e retorna um identificador cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //Define uma opção no identificador de sessão de cURL especificado.
        $curl_response = curl_exec($curl);                  //Execute a sessão cURL fornecida.
        if ($curl_response === false) {
            $info = curl_getinfo($curl);                    //Obtém informações sobre a última transferência.
            curl_close($curl);                              //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
            $decoded = ['erro' => '0'];
        }
        curl_close($curl);                                  //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
        $decoded = json_decode($curl_response);             //Analisa a string codificada JSON e converte-a em uma variável do PHP.
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') { //Caso erro no JSON decoded
            $decoded = ['erro' => '0'];
        }
        $id = 0;

        //chamada da segunda Url...
        if (array_key_exists('erro', $decoded)) {;
            $url = 'http://cep.republicavirtual.com.br/web_cep.php?cep='.$cep.'&formato=json';

            $curl = curl_init($url);                            //Inicializa uma nova sessão e retorna um identificador cURL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //Define uma opção no identificador de sessão de cURL especificado.
            $curl_response = curl_exec($curl);                  //Execute a sessão cURL fornecida.
            if ($curl_response === false) {
                $info = curl_getinfo($curl);                    //Obtém informações sobre a última transferência.
                curl_close($curl);                              //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
                $decoded = ['erro' => '0'];
            }
            curl_close($curl);                                  //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
            $decoded = json_decode($curl_response);             //Analisa a string codificada JSON e converte-a em uma variável do PHP.
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') { //Caso erro no JSON decoded
                 $decoded = ['erro' => '0'];
            }
            $id = 1;
        }

        //chamada da terceira Url...
        if (array_key_exists('erro', $decoded) || ($decoded->resultado == "0")) {
            $url = 'http://api.postmon.com.br/v1/cep/'.$cep;

            $curl = curl_init($url);                            //Inicializa uma nova sessão e retorna um identificador cURL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //Define uma opção no identificador de sessão de cURL especificado.
            $curl_response = curl_exec($curl);                  //Execute a sessão cURL fornecida.
            if ($curl_response === false) {
                $info = curl_getinfo($curl);                    //Obtém informações sobre a última transferência.
                curl_close($curl);                              //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
                $decoded = ['erro' => '0'];
            }
            curl_close($curl);                                  //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
            $decoded = json_decode($curl_response);             //Analisa a string codificada JSON e converte-a em uma variável do PHP.
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') { //Caso erro no JSON decoded
                $decoded = ['erro' => '0'];
            }
            $id = 2;
        }

        //chamada da quarta Url...
        if (array_key_exists('erro', $decoded) || ($decoded == null)) {
            $url = 'http://maps.google.com/maps/api/geocode/json?address='.$cep;

            $curl = curl_init($url);                            //Inicializa uma nova sessão e retorna um identificador cURL
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);   //Define uma opção no identificador de sessão de cURL especificado.
            $curl_response = curl_exec($curl);                  //Execute a sessão cURL fornecida.
            if ($curl_response === false) {
                $info = curl_getinfo($curl);                    //Obtém informações sobre a última transferência.
                curl_close($curl);                              //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
                $decoded = ['erro' => '0'];
            }
            curl_close($curl);                                  //Fecha uma sessão cURL e libera todos os recursos. O controlador cURL, ch, também é deletado.
            $decoded = json_decode($curl_response);             //Analisa a string codificada JSON e converte-a em uma variável do PHP.
            if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') { //Caso erro no JSON decoded
                $decoded = ['erro' => '0'];
            }
            $id = 3;
        }
        if($decoded->status == "ZERO_RESULTS")
        {
            return Retorno::erro('Cep não encontrado.');
        }

        //Chamada da função que trata os dados recebidos pela API que apresentou sucesso ao buscar as informações
        //do CEP informado, cada um devolve informações diferentes por isso faz-se necessário tratar essa informação
        //para que volte de forma integra e relevante;
        $decoded = $this->trataDadosCep($id, $decoded);
        return Retorno::sucesso($decoded);
    }

    /**
    * Método para tratar a string cep
    * @param  string $cep
    * @return string $cep formatada
    */
    public function trataCep($cep)
    {
        //retira caracteres especiais do cep
        $cep = preg_replace('/[^0-9]/', '', $cep);

        //após tratamentos verifica se o cep contém 8 caracteres
        if(strlen($cep) !== 8){
            return Retorno::erro('Cep deve conter 8 números, corrija e tente novamente.');
        }
        return Retorno::sucesso($cep);
    }

    /**
    * Método para tratar os dados recebidos pela API de consulta de CEp
    * @param  int $id
    * @param  string $cep
    * @return string $cep tratada
    */
    public function trataDadosCep($id, $arrDados)
    {
        //Verifica qual foi a API utilizada na busca através da váriavel de controle $id,
        //Cria um array com as informações pertinentes retornada de cada verificação
        switch ($id) {
            case 0:
                $infoCep = [];
                $infoCep = [
                    "logradouro" => $arrDados->logradouro,
                    "complemento" => $arrDados->complemento,
                    "bairro" => $arrDados->bairro,
                    "localidade" => $arrDados->localidade,
                    "ibge" => $arrDados->ibge,
                    "uf" => $arrDados->uf,
                    "Api" => 0
                ];
                return $infoCep;
            break;
            case 1:
                $infoCep = [];
                $infoCep = [
                    "logradouro" => $arrDados->tipo_logradouro.$arrDados->logradouro,
                    "complemento" => '',
                    "bairro" => $arrDados->bairro,
                    "localidade" => $arrDados->cidade,
                    "ibge" => '',
                    "uf" => $arrDados->uf,
                    "Api" => 1
                ];
                return $infoCep;
            break;
            case 2:
                $infoCep = [];
                $infoCep = [
                    "logradouro" => $arrDados->logradouro,
                    "complemento" => '',
                    "bairro" => $arrDados->bairro,
                    "localidade" => $arrDados->cidade,
                    "ibge" =>  $arrDados->cidade_info->codigo_ibge,
                    "uf" => $arrDados->estado,
                    "Api" => 2
                ];
                return $infoCep;
            break;
            case 3:
                $infoCep = [];
                return $arrDados;
                $infoCep = [
                    "logradouro" => '',
                    "complemento" => '',
                    "bairro" => $arrDados->results[0]->address_components[1]->long_name,
                    "localidade" => $arrDados->results[0]->address_components[2]->long_name,
                    "ibge" =>  '',
                    "uf" => $arrDados->results[0]->address_components[3]->short_name,
                    "Api" => 3
                ];
                return $infoCep;
            break;
        }
    }
}

?>
