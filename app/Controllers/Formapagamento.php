<?php

namespace App\Controllers;
use App\Models\FormapagamentosModel;

class Formapagamento extends BaseController{

    public function listar(){
		echo view('forma_pagamento/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new FormapagamentosModel();
        $lista  = (array) $model->get_forma_pagamento(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new FormapagamentosModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_forma_pagamento($id); 
        echo json_encode($registro);
    }  
    
    
    
    /**
    * getAssociacaoJson()
    **/  
    function getAssociacaoJson(){

        $model = new FormapagamentosModel();
        $fpgto_id = $this->request->getPost("fpgto_id");
        $registro  = (array) $model->get_associacaoByFpgto($fpgto_id); 
        echo json_encode($registro);
    }  


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new FormapagamentosModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $data["id"] = $this->request->getPost("id");
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));
        $data["liquidez"] = $this->request->getPost("liquidez");
        $data["taxa_adic"] = $this->request->getPost("taxa_adic");
        $data["parcelas"] = $this->request->getPost("parcelas");
        $data["precisa_cliente"] = ($this->request->getPost("precisa_cliente") === "on") ? '1' : '0';
        $data["gera_comissao"] = ($this->request->getPost("gera_comissao") === "on") ? '1' : '0';
        $data["procard"] = ($this->request->getPost("procard") === "on") ? '1' : '0';
        $data["financeiro"] = ($this->request->getPost("financeiro") === "on") ? '1' : '0';
        $data["ativo"] = ($this->request->getPost("ativo") === "on") ? '1' : '0';
        
        $id = $model->salvar($data);
        if($id){
            $retorno["status"]  = "success";
            $retorno["message"] = "Registro salvo com sucesso!";
            $retorno["id"] = $id;
            echo json_encode($retorno);           
        }
        else{
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível salvar o registro!";	            
            echo json_encode($retorno);                
        }
    }   


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar_associacao(){

        $model = new FormapagamentosModel();        
        
        $cc_id = $this->request->getPost("conta_corrente");
        $fpgto_id = $this->request->getPost("id_fpgto");
        $cliente_id = $this->request->getPost("id_cliente");

        $data = array(
            'forma_pgto_id' => $fpgto_id,
            'conta_id' => $cc_id,            
            'cliente_id' => $cliente_id,
            'ativo' => '1'
        );
        
        $id = $model->salvar_associacao($data);
        if($id){
            $retorno["status"]  = "success";
            $retorno["message"] = "Registro salvo com sucesso!";
            $retorno["id"] = $id;
            echo json_encode($retorno);           
        }
        else{
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível salvar o registro!";	            
            echo json_encode($retorno);                
        }
    }       


    

    /**
    * Excluir dados. Virá no formato form normal, e não em json
    **/  
    function excluir(){

        $model = new FormapagamentosModel();
        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $data["id"]        = $id;
        $data["ativo"]     = '2';

        $id = $model->salvar($data);
        if($id){
            $retorno["status"]  = "success";
            $retorno["message"] = "Registro salvo com sucesso!";
            $retorno["id"] = $id;
            echo json_encode($retorno);           
        }
        else{
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível salvar o registro!";	            
            echo json_encode($retorno);                
        }
    } 
    
}
