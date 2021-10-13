<?php

namespace App\Models;
use CodeIgniter\Model;

class PlanoscontasModel extends Model {

    protected $table = 'plano_contas';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'chave', 'chave_pai', 'descricao', 'ativo'];

    public function get_planocontas($id = 0){
        
        $this->builder = $this->builder('plano_contas pc');
        if ($id === 0){
            return $this->select('pc.id, pc.chave_pai, pc.chave, pc.descricao')                        
                        ->where('pc.ativo', '1')                        
                        ->orderBy('chave')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }   
    
   
    public function salvar($data){
        if (!isset($data)) return 0;        

        $this->builder = $this->builder('plano_contas');
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

    public function getLastChaveFilho($id_pai){
        
        $this->builder = $this->builder('plano_contas pc');
        $this->select('pc.id, pc.chave, pc.chave_pai')                        
                    ->join('plano_contas pc2', 'pc2.chave = pc.chave_pai', 'inner')
                    ->where('pc.chave_pai = pc2.chave')                        
                    ->where('pc2.id', $id_pai)                        
                    ->orderBy('id', 'desc')
                    ->limit('1');
        
        //$compiled = $this->builder->getCompiledSelect(); 
        //return $compiled;
        
        $query = $this->builder->get();
        return $query->getFirstRow();
    }
}