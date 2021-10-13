<?php

namespace App\Controllers;
use App\Models\EmpresasModel;

class Empresa extends BaseController{

    protected $helpers = ['prodabit'];	

    public function listar(){
		echo view('empresa/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new EmpresasModel();
        $lista  = (array) $model->get_empresa(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new EmpresasModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_empresa($id); 
        echo json_encode($registro);
    }    


    /**
    * getListMinJson()
    **/  
    function getListMinJson(){

        $model = new EmpresasModel();        
        $lista  = (array) $model->get_list_empresa_min(); 
        echo json_encode($lista);
    }    
       

    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new EmpresasModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $data["id"] = $this->request->getPost("id");
        $data["codigo"] = strtoupper($this->request->getPost("codigo"));
        $data["codigo_negoc"] = strtoupper($this->request->getPost("codigo_negoc"));
        $data["nome"] = strtoupper($this->request->getPost("nome"));
        $data["cnpj"] = strtoupper($this->request->getPost("cnpj"));
        $data["fundacao"] = $this->request->getPost("fundacao");
        $data["setor_id"] = $this->request->getPost("setor");
        $data["tipo_mercado"] = $this->request->getPost("tipo_mercado");
        $data["tag_along_on"] = $this->request->getPost("tag_along_on");
        $data["tag_along_pn"] = $this->request->getPost("tag_along_pn");
        $data["tag_along_unit"] = $this->request->getPost("tag_along_unit");
        $data["free_float_on"] = $this->request->getPost("free_float_on");
        $data["free_float_pn"] = $this->request->getPost("free_float_pn");
        $data["free_float_total"] = $this->request->getPost("free_float_total");
        $data["majoritario"] = strtoupper($this->request->getPost("majoritario"));
        $data["porc_minoritario"] = $this->request->getPost("porc_minoritario");
        $data["porc_majoritario"] = $this->request->getPost("porc_majoritario");
        $data["governo_on"] = $this->request->getPost("governo_on");
        $data["porc_governo_on"] = $this->request->getPost("porc_governo_on");
        $data["porc_ibovespa"] = $this->request->getPost("porc_ibovespa");
        $data["site_ri"] = $this->request->getPost("site_ri");
        $data["analise"] = ($this->request->getPost("analise") === "on") ? "1" : "0";
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

        $model = new EmpresasModel();
        
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
