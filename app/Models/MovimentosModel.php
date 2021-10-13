<?php

namespace App\Models;
use CodeIgniter\Model;

class MovimentosModel extends Model {

    protected $table = 'movimento';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'usuario_id', 'estacao', 'data_hora_abertura', 'data_hora_fechamento', 'total_suprimento', 'total_sangria', 
                                 'total_venda', 'total_desconto', 'total_acrescimo', 'total_final', 'total_recebido', 'total_troco', 'total_cancelado', 
                                 'status_movimento', 'ativo', 'usuario'];

    
    public function get_movimento($id = 0){
        
        $this->builder = $this->builder('movimento mov');
        if ($id === 0){
            return $this->select('mov.id, mov.estacao, mov.data_hora_abertura, mov.data_hora_fechamento, mov.total_venda, mov.total_desconto')
                        ->select('mov.total_acrescimo, mov.total_final, mov.ativo, mov.status_movimento, usr.nome as usuario')
                        ->join('usuario usr', 'usr.id = mov.usuario_id', 'inner')
                        ->where('mov.ativo <> ', '2')
                        ->orderBy('mov.id', 'desc')
                        ->limit('100')
                        ->get()->getResult();
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