<?php

namespace App\Controllers;
use App\Models\EmpresasModel;
use App\Models\BalancosModel;
use App\Models\CotacoesModel;
//use \Smalot\PdfParser\Parser; /* Aqui você está declarando a classe instalada com o composer*/

class Importacoes extends BaseController{

    protected $helpers = ['prodabit'];	
    protected $base_url = ROOTPATH . '/public/assets/files_import/';


    /**
    * show_form_importar()
    * Exibe a tela de importações
    **/  
    public function show_form_importar(){
        echo view('importacoes/importacoes');      
    }



    /**
    * getIterSourcesJson()
    * Retorna o registro da empresa com o número do link para o arquivo na CVM
    **/  
    function getLinkArquivoEmpresaJson(){

        $cnpj = $this->request->getPost("cnpj");
        if($cnpj === "") return "";

        $model = new BalancosModel();        
        $lista  = (array) $model->get_LinkEmpresaCnpj($cnpj); 
        echo json_encode($lista);
    }  


    function getAnosCadastradosEmpresaJson(){
        $cnpj = $this->request->getPost("cnpj");
        if($cnpj === "") return "";

        $model = new BalancosModel();        
        $lista  = (array) $model->get_AnosCadastradosEmpresaCnpj($cnpj); 
        echo json_encode($lista);
    }


    public function importar_balanco_periodo(){

        $cnpj = $this->request->getPost("cnpj");
        $ini = $this->request->getPost("ini");
        $fim = $this->request->getPost("fim");
        $anual = $this->request->getPost("anual"); 
        $trimestral = $this->request->getPost("trimestral"); 
        
        $tipo = "todos";
        if($anual      === "false") $tipo = "trimestral";
        if($trimestral === "false") $tipo = "anual";

        if($ini == "" || $fim == ""){
            $msg["status"] = "error";
            $msg["message"] = "Periodo do balanço a importar não informado!";
            echo json_encode($msg); return; 
        }
        if($cnpj === ""){
            $msg["status"] = "error";
            $msg["message"] = "CNPJ da empresa não informado!";
            echo json_encode($msg); return; 
        }        
        
        $model = new BalancosModel();        
        $lista  = (array) $model->get_ListaNumerosArquivos($cnpj, $ini, $fim, $tipo); 
        
        if(!$lista || count($lista) === 0){
            $msg["status"] = "error";
            $msg["message"] = "Nenhum registro para importar para o CNPJ informado!";
            echo json_encode($msg); return; 
        }

        $contador = 0;
        foreach($lista as $item){
            $contador += $this->_importar_balanco($cnpj, $item->numero, $item->data);
        }

        $msg["status"] = "success";
        $msg["message"] = $contador . " registros importados!";
        echo json_encode($msg); return;
    }


    
    private function _importar_balanco($cnpj, $numero_arquivo, $data){

        $descompactou = $this->_baixar_e_decompactar_arquivos($numero_arquivo);
        if(!$descompactou) return 0;
        
        $contador = 0;
        //-- Realiza o processamento dos arquivos
        try{
            $contador += $this->_importResultadoEmpresa($cnpj, $data);
            //-- seta o flag de importado do registro
            $model = new BalancosModel();        
            $model->setarFlagArquivoEmpresa($numero_arquivo, '1');  
            return $contador;
        } 
        catch(\Exception $e){
        }   
    }    



    
    /* importResultadoEmpresa - Arquivos necesários:
    *  InfoFinaDFin.xml (contém os dados do balanço patrimonial da emprea)
    *  Documento.xml (Comtém os dados básicos para o cadastro da empresa)
    *  ComposicaoCapitalSocialDemonstracaoFinanceiraNegocios.xml (Qtde de ações no mercado)
    *  PeriodoDemonstracaoFinanceira.xml (Perido inicial e final do balanço)
    */
    private function _importResultadoEmpresa($cnpj, $data_balanco){
        
        //$nome_arquivo = $this->base_url . 'PeriodoDemonstracaoFinanceira.xml';
        //$periodo_ini = (string) $xml->DataInicioPeriodo;
        //$periodo_fim = (string) $xml->DataFimPeriodo;

        //-- Obtém o id da empresa
        $model = new EmpresasModel();
        $empresa_id = $model->get_empresa($cnpj, 'cnpj')->id;
        if($empresa_id == "0") return 0;

        //-- Salva a quantidade de ações da empresa em cada período. Somente se o mês for 12 ou 01 (anual)
        $mes = substr($data_balanco,5,2);
        if($mes === "01" or $mes === "12"){
            $nome_arquivo = $this->base_url . 'ComposicaoCapitalSocialDemonstracaoFinanceiraNegocios.xml';
            $xml2 = simplexml_load_file($nome_arquivo) or die("Error: Cannot create object");
            $qtde_on    = (string) $xml2->ComposicaoCapitalSocialDemonstracaoFinanceira->QuantidadeAcaoOrdinariaCapitalIntegralizado;
            $qtde_pn    = (string) $xml2->ComposicaoCapitalSocialDemonstracaoFinanceira->QuantidadeAcaoPreferencialCapitalIntegralizado;
            $qtde_total = (string) $xml2->ComposicaoCapitalSocialDemonstracaoFinanceira->QuantidadeTotalAcaoCapitalIntegralizado;
            $qtde_tesouraria = (string) $xml2->ComposicaoCapitalSocialDemonstracaoFinanceira->QuantidadeTotalAcaoTesouraria;
            $data = array(
                "empresa_id" => $empresa_id,
                "data"       => $data_balanco,
                "qtde_on"    => $qtde_on,
                "qtde_pn"    => $qtde_pn,
                "qtde_total" => $qtde_total,
                "qtde_tesouraria" => $qtde_tesouraria
            );
            $model->salvarQtdeAcoes($data);
        }
        
        $contador = 0;
        $nome_arquivo = $this->base_url . 'InfoFinaDFin.xml';
        $xml = simplexml_load_file($nome_arquivo) or die("Error: Cannot create object");
        $balancos_model = new BalancosModel();
        
        $data = array();
        $contador = 0;
        foreach($xml as $item){
            
            //-- CodigoTipoInformacaoFinanceira. 1:Individual / 2:Consolidado. Tabela Dominio48 
            $cod_tipo_info    = (string )$item->PlanoConta->VersaoPlanoConta->CodigoTipoInformacaoFinanceira;  

            //-- CodigoTipoDemonstracaoFinanceira. Verificar cógidos Tabela Dominio50.             
            $cod_tipo_demonst = (string )$item->PlanoConta->VersaoPlanoConta->CodigoTipoDemonstracaoFinanceira;             

            //$versao           = (string )$item->PlanoConta->VersaoPlanoConta->NumeroVersaoPlanoConta;
            //$conta_fixa       = (string )$item->PlanoConta->IndicadorContaFixa;
            $cod_plano_conta  = (string )$item->PlanoConta->NumeroConta;       
            $descricao_conta  = (string )$item->DescricaoConta1;            

            $v1  = (string )$item->ValorConta1; //--  valor mais recente
            $v2  = (string )$item->ValorConta2; //--  2º mais recente
            $v3  = (string )$item->ValorConta3; //--  3º mais recente
            $v4  = (string )$item->ValorConta4; //--  4º mais recente
            $v5  = (string )$item->ValorConta5; //--  5º mais recente
            $v6  = (string )$item->ValorConta6; //--  6º mais recente
            $v7  = (string )$item->ValorConta7; //--  7º mais recente
            $v8  = (string )$item->ValorConta8; //--  8º mais recente
            $v9  = (string )$item->ValorConta9; //--  9º mais recente
            $v10 = (string )$item->ValorConta10; //-- 10º mais recente
            $v11 = (string )$item->ValorConta11; //-- 11º mais recente
            $v12 = (string )$item->ValorConta12; //-- 12º mais recente
            
            //-- Encontra o valor mais recente setado. 
            $valor = $v1;
            if($valor == '0') $valor = $v2; if($valor == '0') $valor = $v3; if($valor == '0') $valor = $v4;
            if($valor == '0') $valor = $v5; if($valor == '0') $valor = $v6; if($valor == '0') $valor = $v7;
            if($valor == '0') $valor = $v8; if($valor == '0') $valor = $v9; if($valor == '0') $valor = $v10;
            if($valor == '0') $valor = $v11; if($valor == '0') $valor = $v12; 

            //-- salva dados na tabela codigo_balanço caso ainda não exista
            //-- importa somente os grupos principais do plano de contas (strlen($cod_plano_conta) < 5)
            if(strlen($cod_plano_conta) < 5){ 
                $data = array(
                    "codigo"    => $cod_plano_conta,
                    "descricao" => $descricao_conta,
                    "ativo"     => "1"
                );                
                //-- salva dados na tabela codigo_balanço caso ainda não exista
                $id = $balancos_model->salvar_codigoBalanco($data);            
                $data = array();

                $data["empresa_id"]   = $empresa_id;
                $data["data"]         = $data_balanco;
                $data["codigo_conta"] = $cod_plano_conta;
                $data["valor"]        = $valor;
                $data["tipo_info_financeira"] = $cod_tipo_info;               

                $id = $balancos_model->salvar_resultado($data); 
                if($id > 0){
                    $contador += 1;
                }
            }
        }
        return $contador;
    }



    private  function _importar_links_cvm($arquivo){

        $balancos_model = new BalancosModel();
        $data = array();
        try{
            //-- Abre o arquivo .csv
            if(($handle = fopen($arquivo, "r")) !== FALSE){            
                // Convert each line into the local $data variable
                fgetcsv($handle); //-- salta a primeira linha
                $count = 0;
                while (($linha = fgetcsv($handle, 0, ";")) !== FALSE){		
                    $data["cnpj"]   = $linha[0];                        
                    $data["data"]   = $linha[1];
                    $data["versao"] = $linha[2];
                    $data["numero"] = $linha[6];
                    $data["importado"] = "0";
                    $balancos_model->salvar_links_empresas($data);
                    $count += 1;
                }                
                // Close the file
                fclose($handle);
            }
            return $count;
        }
        catch(\Exception $e){            
        }        
    }

    
    
    public function importar_csv_trimestral_anual_cvm(){

        //-- Apaga todos os arquivos na pasta 
        $this->_deleteFilesFromFolder($this->base_url);

        //-- O número do arquivo no site da CVM
        $ano = $this->request->getPost("ano");
        if($ano === ""){
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível carregar o arquivo csv. Ano do arquivo desejado nao informado!";	            
            echo json_encode($retorno); return;
        }

        //-- Faz o download do arquivo zip com as informações da empresa
        $fileList = Array(
            'dfp_cia_aberta' => 'http://dados.cvm.gov.br/dados/CIA_ABERTA/DOC/DFP/DADOS/dfp_cia_aberta_' . $ano . '.zip', //-- arquivo anual
            'itr_cia_aberta' => 'http://dados.cvm.gov.br/dados/CIA_ABERTA/DOC/ITR/DADOS/itr_cia_aberta_' . $ano . '.zip' //-- arquivo anual
        );

        $descompactou = false;
        foreach($fileList as $key=>$url){    
            $file_headers = @get_headers($url);
            if($file_headers && $file_headers[0] !== 'HTTP/1.1 404 Not Found') {
                $destino = $this->base_url . $key .'_'. $ano . '.zip';
                $file_size = file_put_contents($destino, fopen($url, "r"));
                if($file_size > 0){
                    $descompactou = ($this->unzip($destino));
                }            
            }
        }

        if(!$descompactou){
            $msg["status"] = "error";
            $msg["message"] = "Não foi possível baixar ou descompactar os arquivos dfp e itr!";
            echo json_encode($msg); return; 
        }

        $count = 0;
        $fileList = Array(
            0 => $this->base_url . 'dfp_cia_aberta_' . $ano . '.csv', //-- arquivo anual
            1 => $this->base_url . 'itr_cia_aberta_' . $ano . '.csv', //-- arquivo anual
        );
        
        //-- Realiza o processamento dos arquivos
        foreach($fileList as $nome_arquivo){                
            if(file_exists($nome_arquivo)){
                $count += $this->_importar_links_cvm($nome_arquivo);
            }
        }
        
        if($count > 0){
            $msg["status"] = "success";
            $msg["message"] = $count . " registros salvos com sucesso!";
            echo json_encode($msg);  
        }
        else{
            $msg["status"] = "error";
            $msg["message"] =  "Não foi possível carregar os registros!";	            
            echo json_encode($msg);
        }
    }        
    
 
 
    private function unzip($arquivo){               
        $retorno = false;
        $zip = new \ZipArchive;
        if ($zip->open($arquivo) === TRUE) {
            $zip->extractTo($this->base_url);
            $zip->close();
            $retorno = true;
        }
        return $retorno;
    }  
    
    
    private function _deleteFilesFromFolder($path_to_folder){

        $files = glob($path_to_folder . '*');  // get all file names
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }
    }


    public function updateStockPrices(){

        $data = array();
        $ticker = $this->request->getPost("ticker");
        
        //-- Obtém a última data já cadastrada
        $model = new CotacoesModel();
        $dt_ult_cadastro = $model->getLastDateInserted($ticker); 

        $data["symbol"] = $ticker . '.SAO';
        //$data["function"] = 'TIME_SERIES_DAILY';
        $data["function"] = 'TIME_SERIES_WEEKLY_ADJUSTED';        
        $lista = callAlphavantageAPI('GET', 'query', $data);
        $lista = json_decode($lista, true);
        if(is_Array($lista)){            
            $lista = $lista["Weekly Adjusted Time Series"]; //-- pega a segunda coluna do array, que contém as cotações
                                                            //-- retornar ordenado da data mais atual para a menos atual
            $data = array();
            $cont = 0;
            foreach($lista as $vdata=>$item){
                if($vdata <= $dt_ult_cadastro) break; //-- se a data é menor/igual que a última data cadastrada, sai do loop                

                $data = array(                    
                    "ticker"        => $ticker,
                    "data"          => $vdata,
                    "abertura"      => $item["1. open"],
                    "fechamento"    => $item["4. close"],
                    "fech_ajustado" => $item["5. adjusted close"],
                    "minima"        => $item["3. low"],
                    "maxima"        => $item["2. high"],
                    "volume"        => $item["6. volume"]
                );
                $model->insert($data);
                $cont += 1;
            }
            if($lista){
                $retorno["status"]  = "success";
                $retorno["message"] = $cont . " registros salvos com sucesso!";
                echo json_encode($retorno);           
            }
        }        
        else{
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível carregar as cotações! (Invalid API call).";	            
            echo json_encode($retorno);                
        }
    }    


    public function importarListaEmpresas(){

        $ano = $this->request->getPost("ano");
        if($ano === "") $ano = '2021';
        $model = new BalancosModel();
        $lista = $model->getListNumeroEmpresas($ano);

        $cont = 0;
        foreach($lista as $item){
            try{
                $descompactou = $this->_baixar_e_decompactar_arquivos($item->numero);
                if($descompactou){
                    $retorno = $this->_importa_empresa();
                    if($retorno) $cont += 1;
                }                 
            }
            catch(\Exception $e){}
        }
        $msg["status"]  = "success";
        $msg["message"] = $cont . " registros salvos com sucesso!";
        echo json_encode($msg);  
    }


    private function _importa_empresa(){

                
        //-- Obtém os dados básicos da empresa ----------------------------------------
        //-----------------------------------------------------------------------------        
        $nome_arquivo = $this->base_url . 'Documento.xml';
        $xml = simplexml_load_file($nome_arquivo) or die("Error: Cannot create object");
        $xml = $xml->CompanhiaAberta; //-- ramo do XML
        $codigo_cvm   = (string) $xml->CodigoCvm;
        $razao_social = trim((string) $xml->NomeRazaoSocialCompanhiaAberta);
        $cnpj         = trim((string) $xml->NumeroCnpjCompanhiaAberta);
        $fundacao     = trim((string) $xml->DataConstituicaoEmpresa);
        $setor_id     = trim((string) $xml->CodigoSetorAtividadeEmpresa);

        $model = new EmpresasModel();
        $cnpj = formatCnpjCpf($cnpj);
        $empresa = $model->get_idEmpresaPeloCnpj($cnpj);
        if($empresa) return 0;

        //-- Cadastra a empresa caso não exista o registro
        $data = array(
            "cnpj"         => $cnpj,
            "fundacao"     => substr($fundacao,0,10),
            "nome"         => $razao_social,
            "setor_id"     => $setor_id,
            "tipo_mercado" => "NM",
            "codigo_cvm"   => $codigo_cvm,
            "ativo"        => "1"
        );        
        $id = $model->salvar($data); 
        return $id;
    }


    private function _baixar_e_decompactar_arquivos($numero_arquivo){

        //-- Apaga todos os arquivos na pasta       
        $destino = $this->base_url;
        $this->_deleteFilesFromFolder($destino);

        //-- Faz o download do arquivo zip com as informações da empresa
        $url = 'http://www.rad.cvm.gov.br/ENETCONSULTA/frmDownloadDocumento.aspx?CodigoInstituicao=1&NumeroSequencialDocumento=' . $numero_arquivo;
        $destino = $this->base_url . $numero_arquivo . '.zip';

        $file_size = file_put_contents($destino, fopen($url, "r"));
        if($file_size <= 0) return false;

        //-- descompacta o arquivo baixado. 
        $descompactou = ($this->unzip($destino));
        if (!$descompactou) return false;

        //-- Descompacta o arquivo .itr, que é um arquivo comptactado (onde contém aqueles que queremos) que veio dentro do zip.
        $fileList = glob($this->base_url . '*.{itr,dfp}', GLOB_BRACE);
        $descompactou = false;
        if(isset($fileList)){
            $nome_arquivo = $fileList[0];
            $descompactou = ($this->unzip($nome_arquivo));            
        }
        return $descompactou;
    }

}