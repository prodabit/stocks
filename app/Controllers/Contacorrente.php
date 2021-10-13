<?php

namespace App\Controllers;
use App\Models\ContascorrenteModel;

class Contacorrente extends BaseController{

    public function listar(){
		echo view('conta_corrente/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new ContascorrenteModel();
        $lista  = (array) $model->get_contacorrente(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new ContascorrenteModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_contacorrente($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new ContascorrenteModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $data["id"] = $this->request->getPost("id");
        $data["empresa_id"] = $this->request->getPost("empresa");
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));
        $data["cod_banco"] = $this->request->getPost("cod_banco");
        $data["agencia"] = $this->request->getPost("agencia");
        $data["num_conta"] = $this->request->getPost("num_conta");
        $data["caixa"] = ($this->request->getPost("caixa") === "on") ? "1" : "0";
        $data["padrao"] = ($this->request->getPost("padrao") === "on") ? "1" : "0";
        $data["saldo"] = $this->request->getPost("saldo");
        $data["master"] = ($this->request->getPost("master") === "on") ? "1" : "0";
        $data["ativo"] = ($this->request->getPost("ativo") === "on") ? "1" : "0";
        
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
    function excluir(){

        $model = new ContascorrenteModel();
        
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
