<?php

namespace App\Models;
use CodeIgniter\Model;

class ProcardsModel extends Model {

    protected $table = 'procard';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'status_procard_id', 'procard_classe_id', 'numero', 'saldo', 'data_cadastro', 'senha', 'ultimo_acesso', 'acessos', 
                                'admin', 'usuario', 'email', 'limite_diario', 'limite_credito', 'ativo'];

    public function get_procard($id = 0){
        
        if ($id === 0){
            return $this->select('procard.*, classe.descricao as classe')            
                        ->join('procard_classe classe', 'classe.id = procard.procard_classe_id', 'inner')
                        ->where('procard.ativo <> ', '2')
                        ->orderBy('procard.id', 'desc')
                        ->findAll();

        //$compiled = $this->builder->getCompiledSelect();                            
        //return $compiled;
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

//$compiled = $this->builder->getCompiledSelect();    
}