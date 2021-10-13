<?php

namespace App\Models;
use CodeIgniter\Model;

class AnalisesModel extends Model {

    protected $table = '';
    protected $returnType = 'object';
    protected $allowedFields = ['id'];

    public function get_preco_lucro_liquido($cnpj = "", $ticker = "", $cod_conta = "4.01"){
        
        $vSQL = 
            'select YEAR(cot.data) AS ano, max(cot.fech_ajustado) AS cotacao, IFNULL(tmp.valor, 0) AS valor '.
            'from cotacoes `cot` '.
            'inner join '.
            ' (SELECT year(res.data) as ano, res.codigo_conta, res.valor '.
            ' FROM resultado res '.
            ' INNER JOIN empresa ON empresa.id = res.empresa_id '.
            '    WHERE res.codigo_conta = "' .$cod_conta. '" and empresa.cnpj = ' .addslashes($cnpj). ') tmp ON tmp.ano = YEAR(cot.data) '.
            'where ticker = "' .$ticker. '" and (valor <> 0 or YEAR(NOW()) = YEAR(cot.data)) '.
            'group by YEAR(cot.data) '.
            'order by ano;'; 

        $query = $this->db->query($vSQL, false);
        //return $query->getResult();    
        return $query->getResultArray();            
    } 


    public function getListPrecoxBalanco($cnpj = "", $ticker = "", $ano_inicial){
        
        $vSQL = 
        'select ano, SUM(cotacao) AS cotacao, SUM(v1) AS v1, SUM(v401) AS v401, SUM(v203) AS v203, SUM(v208) AS v208, SUM(v601) AS v601, '.
        '       sum(v605) AS v605, SUM(v603) AS v603, SUM(v307) AS v307, SUM(v399) AS v399 '.
        'from ( '.
        'select YEAR(res.data) AS ano, 0 AS cotacao, res.valor AS v1, res2.valor AS v203, IFNULL(res3.valor, 0) AS v208, IFNULL(res4.valor, 0) AS v601, '.
        '        IFNULL(res5.valor, 0) AS v605, IFNULL(res6.valor, 0) AS v603, IFNULL(res7.valor, 0) AS v307, IFNULL(res8.valor, 0) AS v399, '.
        '        IFNULL(res9.valor, 0) AS v401 '.
        'FROM resultado res '.
        '        INNER JOIN empresa e ON e.id = res.empresa_id '.
        '    LEFT OUTER JOIN resultado res2 ON e.id = res2.empresa_id AND res.data = res2.data AND res2.codigo_conta = \'2.03\' '.
        '    LEFT OUTER JOIN resultado res3 ON e.id = res3.empresa_id AND res.data = res3.data AND res3.codigo_conta = \'2.08\' '.
        '    LEFT OUTER JOIN resultado res4 ON e.id = res4.empresa_id AND res.data = res4.data AND res4.codigo_conta = \'6.01\' '.
        '    LEFT OUTER JOIN resultado res5 ON e.id = res5.empresa_id AND res.data = res5.data AND res5.codigo_conta = \'6.05\' '.
        '    LEFT OUTER JOIN resultado res6 ON e.id = res6.empresa_id AND res.data = res6.data AND res6.codigo_conta = \'6.03\' '.
        '    LEFT OUTER JOIN resultado res7 ON e.id = res7.empresa_id AND res.data = res7.data AND res7.codigo_conta = \'3.07\' '.
        '    LEFT OUTER JOIN resultado res8 ON e.id = res8.empresa_id AND res.data = res8.data AND res8.codigo_conta = \'3.99\' '.
        '    LEFT OUTER JOIN resultado res9 ON e.id = res9.empresa_id AND res.data = res9.data AND res9.codigo_conta = \'4.01\' '.	
        'WHERE e.cnpj = \'' .$cnpj. '\' and res.codigo_conta = \'1\'  AND MONTH(res.data) = 12 AND YEAR(res.data) >= ' .$ano_inicial. ' '.
        'UNION '.
        'select DISTINCT(YEAR(DATA)) AS ano,cotacoes.fech_ajustado AS cotacao,0,0,0,0,0,0,0,0,0 '.
        'FROM cotacoes '.
        'WHERE ticker = \'' .$ticker. '\' and YEAR(DATA) >= ' .$ano_inicial. ' ' .
        'GROUP BY YEAR(DATA)) tmp '.
        'GROUP BY ano;';

        $query = $this->db->query($vSQL, false);
        return $query->getResult();    
        //return $query->getResultArray();            
    }    


    public function getAnoInicialExisteBalanco($cnpj = ""){
        
        $vSQL = 
            'select DISTINCT YEAR(res.data) AS ano '.
            'FROM resultado res inner join empresa on empresa.id = res.empresa_id '.
            'WHERE empresa.cnpj = \'' .$cnpj. '\' and res.codigo_conta = \'1\' '.
            'ORDER BY ano;'; 
        $query = $this->db->query($vSQL, false);
        return $query->getFirstRow();    
    }       
    

    public function get_preco_lucro_liquido_semanal($cnpj = "", $ticker = "", $cod_conta = "4.01", $data_ini = ""){
        
        if($data_ini === ""){
            $ano = new \DateTime();    
            $ano = $ano->format('Y') - 10; 
            $data_ini = $ano . '-01-01';
        }
        
        $vSQL = 
            'select YEAR(cot.data) AS ano, CASE '. 
            '    WHEN MONTH(cot.data) <= 3 THEN \'1\' '.
            '    WHEN MONTH(cot.data)>3 AND MONTH(cot.data) <= 6 THEN \'2\' '.
            '    WHEN MONTH(cot.data)>6 AND MONTH(cot.data)<= 9 THEN \'3\' '.
            '    ELSE \'4\' END AS trimestre, MAX(cot.fech_ajustado) AS cotacao, tmp.valor '.
            'from  cotacoes `cot` INNER JOIN '.
            '    (SELECT YEAR(res.data) AS ano, MONTH(res.data) AS trimestre, res.valor, res.data '.
            '     FROM resultado res '.	
            '     INNER JOIN empresa on empresa.id = res.empresa_id '.    
            '     WHERE res.codigo_conta = "' .$cod_conta. '" and empresa.cnpj = "' .$cnpj. '" AND res.valor > 0) tmp ON YEAR(tmp.data) = YEAR(cot.data) AND MONTH(tmp.data) = MONTH(cot.data) '.
            'where ticker = "' .$ticker. '" and cot.data >= "' .$data_ini. '" '.
            'group by YEAR(cot.data), trimestre '.
            'ORDER BY ano, trimestre;'; 

        $query = $this->db->query($vSQL, false);
        return $query->getResult();    
    }     
    
    


   //$compiled = $this->builder->getCompiledSelect();    
}