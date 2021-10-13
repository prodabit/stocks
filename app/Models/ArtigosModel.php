<?php

namespace App\Models;
use CodeIgniter\Model;

class ArtigosModel extends Model {

    protected $table = 'artigo';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'titulo', 'texto'];                               

    public function get_artigo($id){
        return $this->where('id', $id)->first();
    }      


    public function get_list(){
        return $this->orderBy('titulo')
                    ->findAll();
    }   


    public function salvar($data){        
        if (!isset($data)) return 0;        
        $id = $data["id"];
        if($id > 0){
            $this->save($data);            
            return $id;            
        }
        else{
            $this->insert($data);
            return $this->insertID();            
        }
    }   

    //$compiled = $this->builder->getCompiledSelect();    
}