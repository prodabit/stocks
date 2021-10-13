<?php

namespace App\Models;
use CodeIgniter\Model;

class ConfiguracoesModel extends Model {

    protected $table = 'configuracao';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'baixar_estoque_os', 'centro_custo_os_id', 'plano_contas_os_id', 'centro_custo_cupom_id', 'plano_contas_cupom_id', 
                                'logo', 'desc_tabela_1', 'desc_tabela_2', 'desc_tabela_3', 'leitor_mifare_ativo', 'porta_leitor_mifare', 'fundo_tela', 'preview_impressao', 
                                'imprimir_dados_empresa', 'titulo_cupom', 'rodape_cupom', 'porc_tabela_1', 'porc_tabela_2', 'porc_tabela_3', 
                                'baixa_produto_composto', 'imprimir_senha_cupom', 'digitais', 'imprimir_delivery', 'cliente_vendas_id', 'cliente_transferencia_id', 
                                'ativo'];

    public function get_configuracao(){
        
        $this->builder = $this->builder('configuracao conf');
        return $this->select('conf.*, cc_os.descricao as centro_custo_os, pc_os.descricao as plano_contas_os, cc_vd.descricao as centro_custo_cupom, pc_vd.descricao as plano_contas_cupom')
                    ->select('cli_venda.nome as cliente_vendas, cli_transf.nome as cliente_transferencia')
                    ->join('centro_custo cc_os', 'cc_os.id = conf.centro_custo_os_id', 'inner')
                    ->join('plano_contas pc_os', 'pc_os.id = conf.plano_contas_os_id', 'inner')
                    ->join('centro_custo cc_vd', 'cc_vd.id = conf.centro_custo_cupom_id', 'inner')
                    ->join('plano_contas pc_vd', 'pc_vd.id = conf.plano_contas_cupom_id', 'inner')
                    ->join('pessoa cli_venda', 'cli_venda.id = conf.cliente_vendas_id', 'left')
                    ->join('pessoa cli_transf', 'cli_transf.id = conf.cliente_transferencia_id', 'left')                    
                    ->where('conf.ativo <> ', '2')                        
                    ->findAll();
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