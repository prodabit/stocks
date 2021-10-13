<?php

namespace App\Models;
use CodeIgniter\Model;

class CentrocustosModel extends Model {

    protected $table = 'centro_custo';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'descricao', 'chave', 'chavepai', 'ativo'];

    public function get_centro_custo($id = 0){
        
        if ($id === 0){
            return $this->where('ativo <> ', '2')
                        ->orderBy('id', 'desc')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }      

    
    public function salvar($data){
        if (!isset($data)) return 0;        
        $id = isset($data["id"]) ? $data["id"] : 0;
        
        if($id > 0){
            $this->save($data);            
            return $id;            
        }
        else{
            $this->insert($data);
            return $this->insertID();            
        }
    }   
}