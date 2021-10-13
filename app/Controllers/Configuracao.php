<?php

namespace App\Controllers;
use App\Models\ConfiguracoesModel;

class Configuracao extends BaseController{

    public function listar(){
		echo view('configuracao/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new ConfiguracoesModel();
        $lista  = (array) $model->get_configuracao(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new ConfiguracoesModel();        
        $registro  = (array) $model->get_configuracao()[0]; 
        echo json_encode($registro);
    }      


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $model = new ConfiguracoesModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");

        $data["id"] = $this->request->getPost("id");
        $data["dir_log"] = $this->request->getPost("dir_log");
        $data["dir_backup"] = $this->request->getPost("dir_backup");
        $data["baixar_estoque_os"] = ($this->request->getPost("baixar_estoque_os") === "on") ? "1" : "0";
        $data["centro_custo_os_id"] = $this->request->getPost("centro_custo_os_id");
        $data["plano_contas_os_id"] = $this->request->getPost("plano_contas_os_id");
        $data["centro_custo_cupom_id"] = $this->request->getPost("centro_custo_cupom_id");
        $data["plano_contas_cupom_id"] = $this->request->getPost("plano_contas_cupom_id");
        $data["logo"] = $this->request->getPost("logo");
        $data["desc_tabela_1"] = $this->request->getPost("desc_tabela_1");
        $data["desc_tabela_2"] = $this->request->getPost("desc_tabela_2");
        $data["desc_tabela_3"] = $this->request->getPost("desc_tabela_3");
        $data["leitor_mifare_ativo"] = ($this->request->getPost("leitor_mifare_ativo") === "on") ? "1" : "0";
        $data["porta_leitor_mifare"] = $this->request->getPost("porta_leitor_mifare");
        $data["fundo_tela"] = $this->request->getPost("fundo_tela");
        $data["preview_impressao"] = ($this->request->getPost("preview_impressao") === "on") ? "1" : "0";
        $data["dir_imagens"] = $this->request->getPost("dir_imagens");
        $data["imprimir_dados_empresa"] = ($this->request->getPost("imprimir_dados_empresa") === "on") ? "1" : "0";
        $data["titulo_cupom"] = $this->request->getPost("titulo_cupom");
        $data["rodape_cupom"] = $this->request->getPost("rodape_cupom");
        $data["porc_tabela_1"] = $this->request->getPost("porc_tabela_1");
        $data["porc_tabela_2"] = $this->request->getPost("porc_tabela_2");
        $data["porc_tabela_3"] = $this->request->getPost("porc_tabela_3");
        $data["baixa_produto_composto"] = ($this->request->getPost("baixa_produto_composto") === "on") ? "1" : "0";
        $data["imprimir_senha_cupom"] = ($this->request->getPost("imprimir_senha_cupom") === "on") ? "1" : "0";
        $data["digitais"] = $this->request->getPost("digitais");
        $data["imprimir_delivery"] = ($this->request->getPost("imprimir_delivery") === "on") ? "1" : "0";
        $data["cliente_vendas_id"] = $this->request->getPost("cliente_vendas_id");
        $data["cliente_transferencia_id"] = $this->request->getPost("cliente_transferencia_id");
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

        $model = new ConfiguracoesModel();
        
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
