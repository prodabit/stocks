<?php

namespace App\Controllers;
use App\Models\CadastrogeralModel;

class Cadastrogeral extends BaseController{

    public function listar($modulo){

        switch($modulo){
            case "setor":
                $titulo = 'Setores';
                break;
            case "fabricante":
                $titulo = 'Fabricante';
                break;               
            case "procard_classe":
                $titulo = 'Classes do Procard';
                break;                 
            case "status_procard":
                $titulo = 'Status do  Procard';
                break;                 
            default: 
                $titulo = "Listagem de Dados";
        }        
        $data["modulo"] = $modulo;
        $data["titulo"] = $titulo;		
        echo view('cadastro_geral/list', $data);		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $tabela = $this->request->getPost("tabela");        
        $model = new CadastrogeralModel();
        $lista  = (array) $model->get_items($tabela); 
        echo json_encode($lista);
    }  


    /**
    * getListJson()
    **/ 
    public function getListFiltroJson(){

        $tabela = $this->request->getPost("tabela");
        $filtro = $this->request->getPost("filtro");        
        $model = new CadastrogeralModel();
        $lista  = (array) $model->get_items_filtro($tabela, $filtro); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new CadastrogeralModel();
        $id = $this->request->getPost("id");
        $tabela = $this->request->getPost("tabela");
        $registro  = (array) $model->get_items($tabela, $id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new CadastrogeralModel();        
        
        $tabela = $this->request->getPost("tabela");
        $data["id"] = $this->request->getPost("id");
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));
        $data["ativo"] = $this->request->getPost("ativo") === "on";
        
        $id = $model->salvar($tabela, $data);
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

        $model = new CadastrogeralModel();
        
        //-- somente atualiza senha caso senha enviada
        $tabela = $this->request->getPost("tabela"); 
        $id = $this->request->getPost("id");
        $data["id"]        = $id;
        $data["ativo"]     = '2';

        $id = $model->salvar($tabela, $data);
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


    function getUFEmpresa(){
        $model = new CadastrogeralModel();
        $uf = $model->getUFEmpresa();
        echo json_encode($uf);           
    }


    function getListaCidades(){
        $uf = $this->request->getPost("uf"); 
        $model = new CadastrogeralModel();
        $lista = (array) $model->getListaCidades($uf); 
        echo json_encode($lista);
    }
    
}
