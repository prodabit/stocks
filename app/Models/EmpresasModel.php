<?php

namespace App\Models;
use CodeIgniter\Model;

class EmpresasModel extends Model {

    protected $table = 'empresa';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'setor_id', 'codigo', 'codigo_negoc', 'nome', 'cnpj', 'fundacao', 'setor', 'tipo_mercado', 'tag_along_on', 'tag_along_pn', 'tag_along_unit', 'free_float_on', 
                                'free_float_pn', 'free_float_total', 'majoritario', 'porc_minoritario', 'porc_majoritario', 'governo_on', 'porc_governo_on', 'porc_ibovespa', 'site_ri', 'codigo_cvm', 
                                'empresa_id','qtde_on', 'qtde_pn', 'qtde_total', 'qtde_tesouraria', 'ativo', 'analise', 'numero', 'data', 'versao'];                               

    public function get_empresa($valor = "", $campo = "id"){
        
        $this->select('empresa.*, setor.descricao as setor')
             ->where('empresa.ativo <> ', '2')
             ->join('setor', 'setor.id = empresa.setor_id', 'left');

        if ($valor === ""){
            return $this->orderBy('empresa.id', 'desc')
                        ->findAll();
        }
        else{
            return $this->where('empresa.' . $campo, $valor)
                        ->first();
        }
    }      


    public function get_idEmpresaPeloCnpj($cnpj){
        
        return $this->select('id')
                    ->where('cnpj', $cnpj)
                    ->first();
    }      


    public function get_list_empresa_min(){
        
        return $this->select('id, codigo, ifnull(codigo_negoc, \'\') as codigo_negoc, ifnull(nome,\'\') as nome, cnpj, analise')
                    ->where('empresa.ativo <> ', '2')                        
                    ->orderBy('codigo_negoc')
                    ->findAll();
    }   


    public function salvar($data, $sobrescrever = true){
        
        if (!isset($data)) return 0;        
        $id = $data["id"];
        if(isset($id) && !$sobrescrever) return $data["id"];
        
        //-- Verifica se existe a empresa pelo CNPJ
        if(!isset($id) && $data["cnpj"] !== ""){
            $empresa = $this->get_empresa($data["cnpj"], "cnpj");
            if($empresa) {
                $data["id"] = $empresa->id;
                $id = $empresa->id;
            }
        }
        
        if($id > 0){
            $this->save($data);            
            return $id;            
        }
        else{
            $this->insert($data);
            return $this->insertID();            
        }
    }   


    public function salvarQtdeAcoes($data){
        
        if (!isset($data)) return 0;        
        
        //-- Verifica se existe o registro
        $registro = $this->getQtdeAcoes($data["empresa_id"], $data["data"]);
        if($registro) return $registro->id;

        $this->builder = $this->builder('qtde_acoes_empresa');
        $this->insert($data);
        return $this->insertID();            
    }  

    public function getQtdeAcoes($empresa_id, $data){
        
        $this->builder = $this->builder('qtde_acoes_empresa');
        return $this->where('empresa_id', $empresa_id)
                    ->where('data', $data)                    
                    ->first();
    }  


    public function getListQtdeAcoes($cnpj, $ano_ini){
        
        $this->builder = $this->builder('qtde_acoes_empresa');

        return $this->select('YEAR(DATA) AS ano, qtde_on, qtde_pn, qtde_total, qtde_tesouraria')
                    ->join('empresa', 'empresa.id = qtde_acoes_empresa.empresa_id', 'inner')
                    ->where('empresa.cnpj', $cnpj)
                    ->where('year(data) >=', $ano_ini)                    
                    ->findAll();
    }  

    //$compiled = $this->builder->getCompiledSelect();    
}