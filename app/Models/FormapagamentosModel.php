<?php

namespace App\Models;
use CodeIgniter\Model;

class FormapagamentosModel extends Model {

    protected $table = 'forma_pagamento';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'descricao', 'liquidez', 'taxa_adic', 'parcelas', 'precisa_cliente', 'gera_comissao', 'procard', 'financeiro', 'ativo',
                                'conta_id', 'forma_pgto_id', 'cliente_id'];

    
    
    public function get_forma_pagamento($id = 0){
        
        $this->builder = $this->builder('forma_pagamento fpgto');

        if ($id === 0){
            return $this->select('fpgto.*, cc.descricao as conta_corrente')
                        ->join('associacao_conta_formapgto ass', 'ass.forma_pgto_id = fpgto.id', 'left')
                        ->join('conta_corrente cc', 'cc.id = ass.conta_id', 'left')
                        ->where('fpgto.ativo <> ', '2')
                        ->orderBy('fpgto.descricao', 'asc')
                        ->findAll();
        }
        return $this->where(['fpgto.id' => $id])
                    ->first();
    } 
    

    
    public function get_associacao($id = 0){
        
        $this->builder = $this->builder('associacao_conta_formapgto');
        if ($id === 0){
            return $this->where('ativo <> ', '2')
                        ->orderBy('id', 'desc')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }     


    public function get_associacaoByFpgto($fpgto_id = "0"){
        
        $this->builder = $this->builder('associacao_conta_formapgto ass');
        if ($fpgto_id !== "0"){
            return $this->select('ass.*, pessoa.nome as cliente')
                        ->join('pessoa', 'pessoa.id = ass.cliente_id', 'left outer')
                        ->where(['ass.forma_pgto_id' => $fpgto_id])
                        ->first();
        }     
        else return '';
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


    public function salvar_associacao($data){

        $forma_pgto_id = $data['forma_pgto_id'];
        
        //-- Apaga todos os registros para o usuário 
        $this->builder = $this->builder('associacao_conta_formapgto');
        $this->where('forma_pgto_id', $forma_pgto_id)
             ->delete();

        //-- Salva os dados
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