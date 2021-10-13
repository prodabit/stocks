<?php

namespace App\Controllers;
use App\Models\ProdutosModel;

class Produto extends BaseController{

    public function listar(){
		echo view('produto/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new ProdutosModel();
        $lista  = (array) $model->get_produto(); 
        echo json_encode($lista);
    }  


	/**
    * getListJson()
    **/  	
	public function getListMinJson(){

        $model = new ProdutosModel();
        $lista  = (array) $model->get_produto_min(); 
        echo json_encode($lista);
    }      


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new ProdutosModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_produto($id); 
        if(isset($registro) && $registro['foto'] !== ""){
            if(!file_exists($registro['foto'])) $registro['foto'] = '';
        }
        echo json_encode($registro);
    } 

    
    function getListProdCompostoJson(){
        $model = new ProdutosModel();
        $produto_composto_id = $this->request->getPost("id");
        $lista  = (array) $model->getListProdutoComposto($produto_composto_id); 
        echo json_encode($lista);
    }


    /**
    * getListJson()
    * retorna uma lista de acordo com um filtro enviado. Utilizado no filtro de combos dentro
    * do cadastro de produto.
    **/ 
    public function getListFiltroJson(){

        $filtro = $this->request->getPost("filtro");        
        $model = new ProdutosModel();
        $lista  = (array) $model->get_items_filtro($filtro); 
        echo json_encode($lista);
    }  


    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvar(){

        $foto = $this->request->getFiles();
        if(count($foto) > 0){

            $foto = $foto['foto'];
            if($foto->getName() !== ""){
                $validation =  \Config\Services::validation();
                $input = $this->validate([
                    'file' => [
                        'uploaded[foto]',
                        'mime_in[foto,image/jpg,image/jpeg,image/png,image/gif]',
                        'max_size[foto,100000]'                    
                    ]
                ]);    
                
                if(!$input){  
                    $errors = $validation->getErrors();
                    $retorno["status"] = "error";
                    $retorno["message"] =  "Não foi possível salvar o registro!O(s) arquivo(s) deve(m) estar no formato jpg/jpeg/png e tamanho máximo 100 KBytes. Desc.Adic.(" . $errors['file'] .')';	
                    echo json_encode($retorno);
                    return;
                }
            }
        }        

        $model = new ProdutosModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $delete_foto = $this->request->getPost("excluir_foto") === '1';

        $data["id"] = $id;
        $data["categoria_id"] = $this->request->getPost("categoria");
        $data["fabricante_itens_id"] = $this->request->getPost("fabricante");        
        $data["codigo"] = $this->request->getPost("codigo");
        $data["ean"] = $this->request->getPost("ean");
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));
        $data["cor"] = $this->request->getPost("cor");
        $data["tamanho"] = $this->request->getPost("tamanho");
        $data["serie"] = $this->request->getPost("serie");
        $data["preco_compra"] = $this->request->getPost("preco_compra");
        $data["preco_minimo"] = $this->request->getPost("preco_minimo");
        $data["preco_venda"] = $this->request->getPost("preco_venda");
        $data["estoque"] = $this->request->getPost("estoque");
        $data["estoque_anterior"] = $this->request->getPost("estoque_anterior");
        $data["unidade"] = $this->request->getPost("unidade");
        $data["modelo"] = $this->request->getPost("modelo");        
        $data["data_ult_compra"] = $this->request->getPost("data_ult_compra");
        $data["data_ult_venda"] = $this->request->getPost("data_ult_venda");
        $data["peso"] = $this->request->getPost("peso");
        $data["iat"] = $this->request->getPost("iat");
        $data["ippt"] = $this->request->getPost("ippt");
        $data["comissao"] = $this->request->getPost("comissao");
        $data["ncm"] = $this->request->getPost("ncm");
        $data["cst"] = $this->request->getPost("cst");
        $data["csosn"] = $this->request->getPost("csosn");
        $data["tipo_item_sped"] = $this->request->getPost("tipo_item_sped");
        $data["taxa_ipi"] = $this->request->getPost("taxa_ipi");
        $data["taxa_issqn"] = $this->request->getPost("taxa_issqn");
        $data["taxa_pis"] = $this->request->getPost("taxa_pis");
        $data["taxa_cofins"] = $this->request->getPost("taxa_cofins");
        $data["taxa_icms"] = $this->request->getPost("taxa_icms");
        $data["taxa_fcp"] = $this->request->getPost("taxa_fcp");
        $data["cst_pis"] = $this->request->getPost("cst_pis");
        $data["cst_cofins"] = $this->request->getPost("cst_cofins");
        $data["cst_ipi"] = $this->request->getPost("cst_ipi");
        $data["cfop"] = $this->request->getPost("cfop");
        $data["cest"] = $this->request->getPost("cest");
        $data["tabela"] = ($this->request->getPost("tabela") === "on") ? "1" : "0";
        $data["kit"] = ($this->request->getPost("kit") === "on") ? "1" : "0";
        $data["producao"] = ($this->request->getPost("producao") === "on") ? "1" : "0";
        $data["calcula_peso"] = ($this->request->getPost("calcula_peso") === "on") ? "1" : "0";
        $data["produtos_similares"] = $this->request->getPost("produtos_similares");
        $data["comanda_id"] = $this->request->getPost("comanda_id");
        $data["nutri_id"] = $this->request->getPost("nutri_id");
        $data["ativo"] = ($this->request->getPost("ativo") === "on") ? "1" : "0";

        if($id === "0"){
            $data["data_cadastro"] = date('Y-m-d H:i:s');
        }

        if($delete_foto){
            $data["foto"] = '';        
        } 
        //-- Verifica se foi enviado arquivo de foto.
        else if (isset($_FILES['foto']) && $_FILES['foto']['name'] !== ''){
            //-- tenta fazer upload do arquivo
            $arquivos = $this->request->getFiles();
            $arquivo = upload_arquivo($arquivos);
            $data["foto"] = $arquivo["nome_arquivo"];
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

        $model = new ProdutosModel();
        
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


    

    /**
    * Salvar dados do produtos Kit. 
    **/  
    function saveProdutosKit(){

        $id    = $this->request->getPost("id");
        $lista = $this->request->getPost("tabela");

        if($id == '0'){
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível salvar o registro! Id produto não encontrado.";	            
            echo json_encode($retorno);
            return;
        }

        $model = new ProdutosModel();   
        $id = $model->salvarProdutosKit($id, $lista);
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
