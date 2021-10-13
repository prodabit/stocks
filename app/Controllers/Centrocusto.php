<?php

namespace App\Controllers;
use App\Models\CentrocustosModel;

class Centrocusto extends BaseController{

    public function listar(){
		echo view('centro_custo/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new CentrocustosModel();
        $lista  = (array) $model->get_centro_custo(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new CentrocustosModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_centro_custo($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new CentrocustosModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $delete_foto = $this->request->getPost("excluir_foto") === 'on';

        $data["id"] = $this->request->getPost("id");
$data["descricao"] = $this->request->getPost("descricao");
$data["chave"] = $this->request->getPost("chave");
$data["chavepai"] = $this->request->getPost("chavepai");
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

        $model = new CentrocustosModel();
        
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
