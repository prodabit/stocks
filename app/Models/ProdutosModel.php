<?php

namespace App\Models;
use CodeIgniter\Model;

class ProdutosModel extends Model {

    protected $table = 'produto';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'categoria_id', 'fabricante_itens_id', 'tipi_id', 'codigo', 'ean', 'descricao', 'cor', 'tamanho', 'serie', 'preco_compra', 'preco_minimo', 'preco_venda', 'estoque', 'estoque_anterior', 'foto', 'unidade', 'modelo', 'data_cadastro', 'data_ult_compra', 'data_ult_venda', 'peso', 'iat', 'ippt', 'comissao', 'cst', 'csosn', 'tipo_item_sped', 'taxa_ipi', 'taxa_issqn', 'taxa_pis', 'taxa_cofins', 'taxa_icms', 'taxa_fcp', 'cst_pis', 'cst_cofins', 'cst_ipi', 'cfop', 'cest', 'tabela', 'kit', 'producao', 'calcula_peso', 'produtos_similares', 'comanda_id', 'nutri_id', 'ativo'];

    public function get_produto($id = 0){
        
        if ($id === 0){
            return $this->where('ativo <> ', '2')
                        ->orderBy('id', 'desc')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }      


    public function get_produto_min($id = 0){
        
        if ($id === 0){
            return $this->select('id, codigo, ean, descricao, preco_compra, preco_minimo, preco_venda, estoque, ativo, kit')
                        ->where('ativo <> ', '2')
                        ->orderBy('id', 'desc')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->first();
    }   
    
    
    public function getListProdutoComposto($produto_composto_id){
        
        if ($produto_composto_id === 0) return false;
        
        $this->builder = $this->builder('produto p');
        return $this->select('kit.produto_id, p.codigo, p.ean, p.descricao, p.preco_compra, kit.qtde, kit.valor')
                    ->join('produtos_kit kit', 'p.id = kit.produto_id', 'inner')
                    ->where('p.ativo <> ', '2')
                    ->where('kit.produto_composto_id', $produto_composto_id)
                    ->orderBy('p.descricao')
                    ->get()->getResult();
    }   


    public function get_items_filtro($filtro = ''){
        
        $this->builder = $this->builder('produto p');  
        if ($filtro !== ''){
            return $this->select('p.id, p.descricao, p.codigo, p.ean, p.preco_compra, p.preco_venda')
                        ->where('ativo <> ', '2')
                        ->where('kit', '0')
                        ->like('descricao', $filtro, 'both')
                        ->orLike('codigo', $filtro, 'after')
                        ->orderBy('descricao', 'asc')
                        ->findAll();
            
            //$compiled = $this->getCompiledSelect();
            //return $compiled;
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
    
    
    public function salvarProdutosKit($produto_id, $itens){
        
        //-- exclui todos os produtos do combo na tabela produtos_kit
        $this->builder = $this->builder('produtos_kit');  
        $this->where('produto_composto_id', $produto_id)
             ->delete();

        //-- salva a lista de itens recebida        
        if(count($itens) === 0 ) return 1;

        $vSQL = '';
        foreach($itens as $item){
            if($vSQL !== '') $vSQL .= ',';
            $vSQL .= '(' .$produto_id. ',' .$item[0]. ',"' .$item[4]. '","' .$item[5]. '")';
        }
        $vSQL = 'insert into produtos_kit(produto_composto_id, produto_id, qtde, valor) values' . $vSQL;
        $this->db->query($vSQL);
        return $this->db->affectedRows();
    }


//$compiled = $this->builder->getCompiledSelect();    
}