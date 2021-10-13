<?php

namespace App\Models;
use CodeIgniter\Model;

class ContascorrenteModel extends Model {

    protected $table = 'conta_corrente';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'empresa_id', 'descricao', 'cod_banco', 'agencia', 'num_conta', 'caixa', 'padrao', 'saldo', 'master', 'ativo', 'nome'];

    public function get_contacorrente($id = 0){
        
        $this->builder = $this->builder('conta_corrente cc');  
        if ($id === 0){
            return $this->select('cc.*, empresa.nome as empresa')
                        ->join('empresa', 'cc.empresa_id  = empresa.id', 'inner')
                        ->where('cc.ativo <> ', '2')
                        ->where('empresa.ativo <> ', '2')
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