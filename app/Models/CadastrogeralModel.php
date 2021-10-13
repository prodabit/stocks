<?php

namespace App\Models;
use CodeIgniter\Model;

class CadastrogeralModel extends Model {

    //protected $table = 'fabricante_itens';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'descricao', 'ativo', 'uf'];

    
    public function get_items($tabela, $id = 0){
        
        $this->builder = $this->builder($tabela);  
        if ($id === 0){
            return $this->where('ativo <> ', '2')
                        ->orderBy('descricao')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }      


    public function get_items_filtro($tabela, $filtro = '', $nome_campo = 'descricao'){
        
        $this->builder = $this->builder($tabela);  
        if ($filtro !== ''){
            $this->like($nome_campo, '%'.$filtro.'%');
        }
        
        return $this->select('id, ' . $nome_campo)
                    ->where('ativo <> ', '2')
                    ->orderBy($nome_campo, 'asc')
                    ->findAll();
    }      

    
    public function salvar($tabela, $data){
        
        $this->builder = $this->builder($tabela);  
        if (!isset($data)) return 0;        
        $id = isset($data["id"]) ? $data["id"] : 0;

        if ($id == 0) {
            $this->insert($data);
            return $this->insertID();
        } else {
            $this->builder
                ->where('id', $id)
                ->update($data);
            return $id;
        }
    }   


    public function getUFEmpresa(){

        $builder = $this->builder('empresa');
        $query = $builder->select('uf')->where('ativo <> ', '2')->get();
        $uf = $query->getFirstRow();  // returns an array of objects 
        return $uf;
    }


    public function getListaCidades($uf){
        $builder = $this->builder('cidade');
        $query = $builder->select('id, municipio as cidade')
                         ->where('uf_sigla', $uf)
                         ->orderBy('cidade')
                         ->get();
        $lista = $query->getResult();  // returns an array of objects 
        return $lista;
    }
}