<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuariosModel extends Model {

    protected $table = 'usuario';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'login', 'senha', 'nome', 'ativo'];

    public function get_usuario($id = 0){
        
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