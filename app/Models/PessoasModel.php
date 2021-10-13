<?php

namespace App\Models;
use CodeIgniter\Model;

class PessoasModel extends Model {

    protected $table = 'pessoa';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'cidade_id', 'nome', 'rua', 'numero', 'complemento', 'bairro', 'cep', 'cpf', 'rg', 'cnpj', 'insc_mun', 'insc_est', 'foto', 'restricao', 
                                'contato', 'referencia', 'data_cadastro', 'suframa', 'limite_credito', 'numero_cartao', 'juridica', 'fornecedor', 'transportador', 'ativo',
                                'cidade', 'uf', 'tipo_contato', 'contato'];

    public function get_pessoa($id = 0){
        
        $builder = $this->builder('pessoa');
        $builder->select('pessoa.*, cidade.municipio as cidade, cidade.uf_sigla as uf')
                ->join('cidade', 'cidade.id = pessoa.cidade_id', 'inner')
                ->where('pessoa.ativo <> ', '2')
                ->orderBy('pessoa.id', 'desc');
        
        if ($id === 0){
            $query = $builder->get(); 
            return $query->getResult();       
        }
        else{
            $builder->where(['pessoa.id' => $id]);
            $query = $builder->get(); 
            return $query->getRow();
        }
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


    public function get_pessoaContatos($pessoa_id = "0"){
        
        if($pessoa_id === "0"){
            return false;
        }

        $builder = $this->builder('pessoa_contato pc');
        $builder->select('pc.tipo_contato, pc.contato')                
                ->where('pc.pessoa_id', $pessoa_id);
        
        $query = $builder->get(); 
        return $query->getResult();       
    }

    public function deletePessoaContatos($pessoa_id = "0"){
        
        if($pessoa_id === "0"){return 0;}

        $builder = $this->builder('pessoa_contato');
        $builder->where('pessoa_id', $pessoa_id)
                ->delete();        
        return true;
    }


    public function salvarContato($data){

        if (!isset($data)) return 0;        
        $builder = $this->builder('pessoa_contato');
        $builder->insert($data);
        return $this->insertID();        
    }      
    
    
    public function get_items_filtro($filtro = ''){
        
        $this->builder = $this->builder('pessoa p');  
        if ($filtro !== ''){
            return $this->select('p.id, p.nome, p.rua, p.numero, p.bairro')
                        ->where('ativo <> ', '2')
                        ->like('p.nome', $filtro, 'both')
                        ->orLike('p.rua', $filtro, 'after')
                        ->orderBy('p.nome', 'asc')
                        ->findAll();
            
            //$compiled = $this->getCompiledSelect();
            //return $compiled;
        }
    }          




//$compiled = $this->builder->getCompiledSelect();    
}