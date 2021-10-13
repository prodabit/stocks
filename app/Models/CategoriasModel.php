<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriasModel extends Model {

    protected $table = 'categoria';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'descricao', 'ordem', 'foto', 'ativo', 'auto_atendimento'];                                
    //protected $protectFields = false; //-- retira a necessidade de declarar os campos em allowedFields


    public function get_categoria($id = 0){
        
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