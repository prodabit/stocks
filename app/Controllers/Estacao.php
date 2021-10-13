<?php

namespace App\Controllers;
use App\Models\EstacoesModel;

class Estacao extends BaseController{

    public function listar(){
		echo view('estacao/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new EstacoesModel();
        $lista  = (array) $model->get_estacao(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new EstacoesModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_estacao($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new EstacoesModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $data["id"] = $this->request->getPost("id");
        $data["nome"] = strtoupper($this->request->getPost("nome"));
        $data["local"] = strtoupper($this->request->getPost("local"));
        $data["ativo"] = $this->request->getPost("ativo") === "on";
        
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

        $model = new EstacoesModel();
        
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
