<?php

namespace App\Controllers;
use App\Models\CategoriasModel;

class Categoria extends BaseController{
	
	public function index(){
		return view('tables');
	}

	
	/**
    * getListJson()
    **/  	
	public function getListJson(){

        $model = new CategoriasModel();
        $lista  = (array) $model->get_categoria(); 
        echo json_encode($lista);
    }  


    /**
    * getIlpiJson()
    **/  
    function getRegistroJson(){

        $model = new CategoriasModel();
        $id = $this->request->getPost("id");
        $registro  = (array) $model->get_categoria($id); 
        echo json_encode($registro);
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


        $model = new CategoriasModel();        
        //-- somente atualiza senha caso senha enviada
        $id = $this->request->getPost("id");
        $delete_foto = $this->request->getPost("excluir_foto") === 'on';

        $data["id"]        = $id;
        $data["descricao"] = strtoupper($this->request->getPost("descricao"));
        $data["ordem"]     = $this->request->getPost("ordem");            
        $data["auto_atendimento"] = $this->request->getPost("auto_atendimento") === 'on';         
        $data["ativo"]            = $this->request->getPost("ativo") === 'on'; 
        
        if($delete_foto){
            $data["foto"] = '';        
        } 
        //-- Verifica se foi enviado arquivo de foto.
        else if (isset($_FILES['foto']) && $_FILES['foto']['name'] !== ''){
            //-- tenta fazer upload do arquivo
            $arquivo = $this->_upload_arquivo();
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

        $model = new CategoriasModel();
        
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
    * _upload_arquivo()
    * Pega a imagem e envia para a pasta assets\media
    * Retorna uma array [status, msg, nome_arquivo]
    **/    
    private function _upload_arquivo(){        
        
        $retorno = array();
        $arquivos = $this->request->getFiles();
        $foto = $arquivos['foto'];
        if ($foto->isValid() && ! $foto->hasMoved()){
            $newName = $foto->getRandomName();
            $dest = ROOTPATH . '/public/assets/media';
            $foto->move($dest, $newName);  

            $retorno = array(
                'status' => 'success',                    
                'msg' => 'Arquivo carregado com sucesso!',
                'nome_arquivo' => $newName,
                'file_size' => $foto->getSize()
            );                      
        }
        else{
            $retorno = array(
                'status' => 'error',
                'msg' => 'O arquivo deve estar no formato jpg/jpeg/png e tamanho máximo 100 KBytes.',
                'nome_arquivo' => 'no-image.jpg',
                'file_size' => 0
            );                
        }
        return $retorno;
    }


}
