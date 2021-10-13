<?php

namespace App\Controllers;
use App\Models\PessoasModel;

class Pessoa extends BaseController{

    protected $helpers = ['prodabit'];	

    public function listar(){
		echo view('pessoa/list');		
	}
	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new PessoasModel();
        $lista  = (array) $model->get_pessoa(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new PessoasModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_pessoa($id); 
        if(isset($registro) && $registro['foto'] !== ""){
            if(!file_exists($registro['foto'])) $registro['foto'] = '';
        }
        echo json_encode($registro);
    }    
    
    
    /**
    * getListJson()
    * retorna uma lista de acordo com um filtro enviado. Utilizado no filtro de combos dentro
    * do cadastro de produto.
    **/ 
    public function getListFiltroJson(){

        $filtro = $this->request->getPost("filtro");        
        $model = new PessoasModel();
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

        $model = new PessoasModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $delete_foto = $this->request->getPost("excluir_foto") === '1';  
        $data["id"] = $this->request->getPost("id");
        $data["cidade_id"] = $this->request->getPost("cidade");
        $data["nome"] = strtoupper($this->request->getPost("nome"));
        $data["rua"] = strtoupper($this->request->getPost("rua"));
        $data["numero"] = $this->request->getPost("numero");
        $data["complemento"] = strtoupper($this->request->getPost("complemento"));
        $data["bairro"] = strtoupper($this->request->getPost("bairro"));
        $data["cep"] = $this->request->getPost("cep");
        $data["cpf"] = $this->request->getPost("cpf");
        $data["rg"] = $this->request->getPost("rg");
        $data["cnpj"] = $this->request->getPost("cnpj");
        $data["insc_mun"] = $this->request->getPost("insc_mun");
        $data["insc_est"] = $this->request->getPost("insc_est");
        $data["foto"] = $this->request->getPost("foto");
        $data["restricao"] = $this->request->getPost("restricao");
        $data["contato"] = $this->request->getPost("contato");
        $data["referencia"] = $this->request->getPost("referencia");        
        $data["suframa"] = $this->request->getPost("suframa");
        $data["limite_credito"] = $this->request->getPost("limite_credito");
        $data["numero_cartao"] = $this->request->getPost("numero_cartao");
        $data["juridica"] = ($this->request->getPost("juridica") === "on") ? "1" : "0";
        $data["fornecedor"] = ($this->request->getPost("fornecedor") === "on") ? "1" : "0";
        $data["transportador"] = ($this->request->getPost("transportador") === "on") ? "1" : "0";
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

        $model = new PessoasModel();
        
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
    * getContatosPessoa()
    **/  	
	public function getContatosPessoa(){

        $pessoa_id = $this->request->getPost("pessoa_id");
        $model = new PessoasModel();
        $lista  = (array) $model->get_pessoaContatos($pessoa_id); 
        echo json_encode($lista);
    }  

    
    /**
    * Salvar dados. Virá no formato form normal, e não em json
    **/  
    function salvarContatos(){

        $pessoa_id = $this->request->getPost("pessoa_id");
        if(!isset($pessoa_id) or $pessoa_id === ""){
            $retorno["status"] = "error";
            $retorno["message"] =  "Não foi possível salvar o registro. ID Pessoa não encontrado!";	            
            echo json_encode($retorno);                
            return;
        }        
        
        $model = new PessoasModel();        
        $model->deletePessoaContatos($pessoa_id);
        
        //-- Salva cada registro de contatos
        $data = array();
        $data['pessoa_id'] = $pessoa_id;

        for ($i = 1; $i <= 5; $i++) {
            $tipo    = $this->request->getPost("tipo_contato" .$i);
            $contato = $this->request->getPost("contato" .$i);
            if($tipo !== "" && $contato !== ""){
                
                $data['tipo_contato'] = $tipo;
                $data['contato'] = $contato;
                $id = $model->salvarContato($data);
                if($id <= 0){
                    $retorno["status"] = "error";
                    $retorno["message"] =  "Não foi possível salvar o registro!";	            
                    echo json_encode($retorno);                
                    return;
                }
            }            
        }
        if($id){
            $retorno["status"]  = "success";
            $retorno["message"] = "Registro salvo com sucesso!";
            $retorno["id"] = $id;
            echo json_encode($retorno);           
        }
    }   
    
}
