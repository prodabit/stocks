<?php

namespace App\Controllers;
use App\Models\MovimentosModel;

class Movimento extends BaseController{

    public function listar(){
		echo view('movimento/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new MovimentosModel();
        $lista  = (array) $model->get_movimento(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new MovimentosModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_movimento($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new MovimentosModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $delete_foto = $this->request->getPost("excluir_foto") === 'on';

        $data["id"] = $this->request->getPost("id");
        $data["usuario_id"] = $this->request->getPost("usuario_id");
        $data["estacao"] = $this->request->getPost("estacao");
        $data["data_hora_abertura"] = $this->request->getPost("data_hora_abertura");
        $data["data_hora_fechamento"] = $this->request->getPost("data_hora_fechamento");
        $data["total_suprimento"] = $this->request->getPost("total_suprimento");
        $data["total_sangria"] = $this->request->getPost("total_sangria");
        $data["total_venda"] = $this->request->getPost("total_venda");
        $data["total_desconto"] = $this->request->getPost("total_desconto");
        $data["total_acrescimo"] = $this->request->getPost("total_acrescimo");
        $data["total_final"] = $this->request->getPost("total_final");
        $data["total_recebido"] = $this->request->getPost("total_recebido");
        $data["total_troco"] = $this->request->getPost("total_troco");
        $data["total_cancelado"] = $this->request->getPost("total_cancelado");
        $data["status_movimento"] = ($this->request->getPost("status_movimento") === "on") ? "1" : "0";
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

        $model = new MovimentosModel();
        
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
