<?php

namespace App\Controllers;
use App\Models\PermissoesModel;

class Permissao extends BaseController{

    public function listar(){
		echo view('permissao/list');		
	}


    
    /**
    * getUsersListJson()
    **/  	
	public function getUsersListJson(){

        $model = new PermissoesModel();
        $lista  = (array) $model->get_usuarios(); 
        echo json_encode($lista);
    }  
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $usuario_id = $this->request->getPost("usuario_id");
        $model = new PermissoesModel();
        $lista  = (array) $model->get_permissao(0, $usuario_id); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new PermissoesModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_permissao($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $usuario_id = $this->request->getPost("usuario_id");
        $usuario_source_id = $this->request->getPost("usuario_source_id");
        $menu_ids   = $this->request->getPost("menu_ids");

        $data['usuario_id'] = $usuario_id;
        $data['usuario_source_id'] = $usuario_source_id;
        $data['menu_ids'] = $menu_ids;

        $model = new PermissoesModel();        
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

        $model = new PermissoesModel();
        
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
