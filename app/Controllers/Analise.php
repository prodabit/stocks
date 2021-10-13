<?php

namespace App\Controllers;
use App\Models\AnalisesModel;
use App\Models\CotacoesModel;
use App\Models\EmpresasModel;
use App\Models\BalancosModel;
use LengthException;

class Analise extends BaseController{

    public function preco_lucro(){
		echo view('analise/preco-lucro');		
	}
	
	/**
    * getPrecoLucro()
    **/  	
	public function getListPrecoLucroJson(){
        $cnpj      = $this->request->getPost("cnpj");
        $ticker    = $this->request->getPost("ticker");
        $cod_conta = $this->request->getPost("conta");
        
        $model = new AnalisesModel();
        $lista  = (array) $model->get_preco_lucro_liquido($cnpj, $ticker, $cod_conta); 
        if($lista && count($lista) > 0){
            //-- Obtém a última cotação
            $model = new CotacoesModel();            
            $last = $model->getUltimaCotacao($ticker, 'fech_ajustado');
            //$linha = clone $lista[count($lista)-1];
            $linha = $lista[count($lista)-1];
            $linha["cotacao"] = $last->fech_ajustado;
            $linha["ano"] = $linha["ano"] ."P"; //-- marca como parcial
            array_push($lista, $linha);

            $lista = $this->_normalizaListaByPrice($lista);
            //$lista = $this->_normalizaListaPorcentagem($lista);
        }
        echo json_encode($lista);
    }  


    private function _normalizaListaByPrice($lista){

        //-- cria o indice dividindo o valor pela primeira cotação
        $idx = $lista[0]["valor"] / $lista[0]["cotacao"];

        //-- lista: {ano, cotacao, valor}        
        foreach($lista as $key=>$item){
            //$item["cotacao"] = $item["cotacao"] / $idx;
            $lista[$key]["valor"]  = $lista[$key]["valor"] / $idx;
        }
        return $lista;
    }


	/**
    * getListPrecoxBalanco()
    **/  	
	public function getListPrecoxBalanco(){
        
        $cnpj      = $this->request->getPost("cnpj");
        $ticker    = $this->request->getPost("ticker");
        
        $model = new AnalisesModel();
        $ano_inicial = $model->getAnoInicialExisteBalanco($cnpj);
        if(!$ano_inicial) return "";

        $resultado = array();
        
        //-- Adiciona as ano e cotações no array de resultados
        $model = new CotacoesModel();
        $data_ini = $ano_inicial->ano . '-01-01';
        $lista = $model->getListCotacoes($ticker, $data_ini, "fech_ajustado", "anual");
        if(count($lista) == 0) return;
        
        $first_cotacao = $lista[0]->cotacao;
        foreach($lista as $key=>$item){
            if($key > 0){
                $resultado["label"]    .= ',';
                $resultado["cotacoes"] .= ','; 
            } 
            $resultado["label"]    .= $item->ano;
            $resultado["cotacoes"] .= $item->cotacao;   
        }

        //-- retorna a quantidade de ações
        $model = new EmpresasModel();
        $lista = $model->getListQtdeAcoes($cnpj, $ano_inicial->ano);
        $idx = $this->obterIndice($first_cotacao, $lista, "qtde_total");
        $resultado["qtde_acoes"] = '';
        foreach($lista as $key=>$item){
            if($key > 0) $resultado["qtde_acoes"]    .= ',';
            $resultado["qtde_acoes"] .= $item->qtde_total / $idx;
        }

        //-- retorno lucro líquido (4.01)
        $model = new BalancosModel();
        
        $lst_balancos = array("1", "2.03", "4.01", "6.01");
        foreach($lst_balancos as $balanco){
            $lista = $model->getListBalanco($cnpj, $ano_inicial->ano, $balanco);
            $idx = $this->obterIndice($first_cotacao, $lista, "valor");
            $chave = 'v' . str_replace('.', '', $balanco);
            foreach($lista as $key=>$item){
                if($key > 0) $resultado[$chave] .= ',';
                if($key == 0 and $item->valor == 0){
                    $resultado[$chave] = $first_cotacao;
                }
                else{
                    $resultado[$chave] .= round($item->valor / $idx, 2);
                }                
            }
            if($lista[$key] == '0') $lista[$key] = $lista[$key-1];
        }

        foreach($resultado as $key=>$value){
            if($key !== "label"){
                $resultado[$key] = '[' . $resultado[$key] . ']'; 
            }
        }
        echo json_encode($resultado);
    }  


    private function obterIndice($cotacao, $lista, $nome_campo){
        
        if($cotacao == 0) $cotacao = 1;
        $retorno = 1;
        foreach($lista as $item){
            if($item->$nome_campo != 0){
                $retorno = round($item->$nome_campo/$cotacao);
                break;
            }
        }
        return $retorno;
    }



    public function getListPrecoLucroSemanalJson(){

        $cnpj      = $this->request->getPost("cnpj");
        $ticker    = $this->request->getPost("ticker");
        $cod_conta = $this->request->getPost("conta");
        
        $model = new AnalisesModel();
        $lista  = (array) $model->get_preco_lucro_liquido_semanal($cnpj, $ticker, $cod_conta); 

        //-- retira da lista o primeiro item se for do 4º trimestre
        //- isto porque o valor que vem no 4º é na realizada o valor agregado do ano todo, e daria difereça na geração do gráfico
        if($lista[0]->trimestre == "4") array_shift($lista);
        
        //-- processar a lista, para corrigir o valor do 4º trimestre
        $anteriores = 0;
        foreach($lista as $item){
            if($item->trimestre != "4"){
                $anteriores += $item->valor;
            }
            else{
                $item->valor = $item->valor - $anteriores;
                $anteriores = 0;
            }
        }
        echo json_encode($lista);
    } 
}
