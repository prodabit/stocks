<?php

namespace App\Controllers;
use App\Models\PlanoscontasModel;

class Planocontas extends BaseController{

    public function listar(){
		echo view('plano_contas/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new PlanoscontasModel();
        $lista  = (array) $model->get_planocontas(); 
        echo json_encode($lista);
    }  


	/**
    * getListJsonRecursive()
    **/  	
    public function getListRecursiveJson(){

        $model = new PlanoscontasModel();
        $lista  = (object) $model->get_planocontas(); 

        $roots = array();
        foreach ($lista as $row) {
            $roots[$row->chave_pai][] = $row;            
        }

        // starting with level 0
        $retorno = $this->_add_children($roots, '00');
        $retorno = $this->buildMenu($retorno);
        echo '<ul id="tree_view">' . $retorno . '</ul>';
    }


    public function _add_children($lista, $chave_pai){

        $nested_array = array();
        foreach($lista[$chave_pai] as $item){
            $obj = (object) [];
            $obj->id = $item->id;
            $obj->chave = $item->chave;
            $obj->chave_pai = $item->chave_pai;
            $obj->descricao = $item->descricao;            
            
            // check if there are children for this item
            if(isset($lista[$item->chave])){
                $obj->children = $this->_add_children($lista, $item->chave); // and here we use this nested function again (and again)
            }
            $nested_array[] = $obj;
        }
        return $nested_array;
    }


    function buildMenu($list){
        
        $span = ''; 
        $retorno = '';
        foreach ($list as $item){
            
            (empty($item->children)) ?  ($span = '') : ($span = '<i class="bi bi-caret-right-fill caret"></i> ');
            
            $retorno .= '<li class="font-weight-normal" id="' .$item->id. '">' .$span. $item->descricao;            
            if (!empty($item->children)){
                $retorno .= '<ul class="nested">' . $this->buildMenu($item->children) . '</ul>';
            }
            $retorno .= '</li>';
        }        
        return $retorno;
    }

    

    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new PlanoscontasModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_planocontas($id); 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new PlanoscontasModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $novo = $this->request->getPost("novo") === 'true';
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));

        //-- novo registro
        if($novo){
            $data["id"] = '0';
            $data["ativo"] = '1';          
            
            //-- assume que o pai do registro não tem filhos
            $pai = $model->get_planocontas($id);
            $data["chave"] = $pai->chave . '01';
            $data["chave_pai"] = $pai->chave;

            //-- mas verificamos se tem filho. Se tiver, pega o último e adiciona 1
            $pai = $model->getLastChaveFilho($id);
            if(isset($pai)){
                $prox = substr($pai->chave, -2); 
                $prox = intval($prox) +1;
                $prox = sprintf("%02d", $prox); 
                $chave_pai = $pai->chave_pai;
            }
        }
        
        //-- salvar registro existente
        else{
            $data["id"] = $this->request->getPost("id");            
            $data["ativo"] = ($this->request->getPost("ativo") === "on") ? "1" : "0";
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

        $model = new PlanoscontasModel();
        
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
