<?php

namespace App\Models;
use CodeIgniter\Model;

class CotacoesModel extends Model {

    protected $table = 'cotacoes';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'ticker', 'data', 'abertura', 'fechamento', 'minima', 'maxima', 'volume', 'fech_ajustado'];

    public function getLastDateInserted($ticker){
        
        if ($ticker === "") return null;
        return $this->selectMax('data')
                    ->where('ticker', $ticker)
                    ->first()->data;
    }    
    
    public function getUltimaCotacao($ticker, $campo = "fech_ajustado"){
        
        if ($ticker === "") return null;
        return $this->select($campo)
                    ->where('ticker', $ticker)
                    ->orderBy('data', 'desc')
                    ->limit('1')
                    ->first();
    }  
    
    
    public function getListCotacoes($ticker, $data_ini, $campo = "fech_ajustado", $periodo = "anual"){
        
        $group = 'group by year(data)';
        if($periodo === 'mensal') $group = 'group by year(data), month(data)';
        if($periodo === 'diario') $group = '';

        $this->builder = $this->builder('cotacoes');
        $vSQL = 
            'select DISTINCT(YEAR(DATA)) AS ano, ' .$campo. ' AS cotacao '.
            'FROM cotacoes '.
            'WHERE ticker = \'' .$ticker. '\' and data >= \'' .$data_ini. '\' ';
            if($group !== "") $vSQL .= $group;
            $vSQL .= ' order by data;';

        $query = $this->db->query($vSQL, false);
        return $query->getResult();    
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