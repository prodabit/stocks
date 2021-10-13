<?php

namespace App\Controllers;
use App\Models\ProcardsModel;

class Procard extends BaseController{

    protected $helpers = ['prodabit'];

    public function listar(){
		echo view('procard/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new ProcardsModel();
        $lista  = (array) $model->get_procard(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new ProcardsModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_procard($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $id = $this->request->getPost("id");
        $senha = $this->request->getPost("senha");
        if($id == "0" && $senha === ""){
            $retorno["status"] = "error";
            $retorno["message"] =  "Senha deve ser preenchida!";	            
            echo json_encode($retorno);  
            return;
        }        
        
        /* Verifica se senha foi enviada */        
        $conf_senha = $this->request->getPost("conf_senha");
        if($senha !== "" && $senha !== $conf_senha){
            $retorno["status"] = "error";
            $retorno["message"] =  "Senha diferente de confirmação de senha!";	            
            echo json_encode($retorno);  
            return;
        }

        if($senha !== "" && strlen($senha) < 4){
            $retorno["status"] = "error";
            $retorno["message"] =  "Senha deve ter ao menos 04 dígitos!";	            
            echo json_encode($retorno);  
            return;
        }

        $model = new ProcardsModel();        
        //-- somente atualiza senha caso senha enviada
        
        $data["id"] = $id;
        $data["status_procard_id"] = $this->request->getPost("status_procard");
        $data["procard_classe_id"] = $this->request->getPost("procard_classe");
        $data["numero"] = $this->request->getPost("numero");
        $data["saldo"] = $this->request->getPost("saldo");        
        $data["acessos"] = $this->request->getPost("acessos");
        $data["admin"] = ($this->request->getPost("admin") === "on") ? "1" : "0";
        $data["usuario"] = strtoupper($this->request->getPost("usuario"));
        $data["email"] = $this->request->getPost("email");
        $data["limite_diario"] = $this->request->getPost("limite_diario");
        $data["limite_credito"] = $this->request->getPost("limite_credito");
        $data["ativo"] = ($this->request->getPost("ativo") === "on") ? "1" : "0";        
        $data["data_cadastro"] = date('Y-m-d H:i:s');        
        $data["ultimo_acesso"] = date('Y-m-d H:i:s');

        if($senha !== ""){
            $senha = CriptografarSenhaJoomla($senha);
            $data["senha"] = $senha;
        } 

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

        $model = new ProcardsModel();
        
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
