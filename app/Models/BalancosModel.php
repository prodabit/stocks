<?php

namespace App\Models;
use CodeIgniter\Model;

class BalancosModel extends Model {

    protected $table = 'resultado';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'codigo', 'descricao', 'ativo', 'empresa_id', 'data', 'codigo_conta', 'valor',
                                'cnpj', 'numero', 'data', 'versao', 'importado', 'tipo_info_financeira'];

    
    public function get_empresa($valor = "", $campo = "id"){
        
        $this->select('empresa.*, setor.descricao as setor')
             ->where('empresa.ativo <> ', '2')
             ->join('setor', 'setor.id = empresa.setor_id', 'inner');

        if ($valor === ""){
            return $this->orderBy('empresa.id', 'desc')
                        ->findAll();
        }
        else{
            return $this->where('empresa.' . $campo, $valor)
                        ->first();
        }
    }      


    public function get_list_empresa_min(){
        
        return $this->select('id, codigo, codigo_negoc, nome')
                    ->where('empresa.ativo <> ', '2')                        
                    ->orderBy('nome')
                    ->findAll();
    }        



    public function salvar_codigoBalanco($data){
        
        $this->builder = $this->builder('codigo_balanco');
        if (!isset($data)) return 0;        
        $id = isset($data["id"]) ? $data["id"] : 0;
        
        //-- Verifica se existe a empresa pelo CNPJ
        if($id == "0"){
            $codigo_balanco = $this->get_codigoBalanco($data['codigo']);
            if($codigo_balanco) return $codigo_balanco->id;
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


    public function get_codigoBalanco($codigo){
        $this->builder = $this->builder('codigo_balanco');
        return $this->where('codigo', $codigo)->first();
    }      


    public function salvar_resultado($data){
        
        $this->builder = $this->builder('resultado');
        if (!isset($data)) return 0;        
        $id = isset($data["id"]) ? $data["id"] : 0;
        
        //-- Verifica se existe resultado cadastrado
        if($id == "0"){
            $retorno = $this->get_resultado($data['empresa_id'], $data['data'], $data['codigo_conta']);
            if($retorno) {
                $id = $retorno->id;
                $data["id"] = $id;
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


    public function get_resultado($empresa_id, $data, $codigo_conta){
        
        $this->builder = $this->builder('resultado');
        return $this->where('empresa_id', $empresa_id)
                    ->where('data', $data)                    
                    ->where('codigo_conta', $codigo_conta)        
                    ->first();
    }   


    public function getListBalanco($cnpj, $ano_ini, $codigo_conta, $periodo = 'anual'){
        
        $ano_atual = new \DateTime();    
        $ano_atual = $ano_atual->format('Y');

        $vSQL = 
            'select * FROM( '.
            'select MONTH(res.data) AS mes, YEAR(res.data) AS ano, res.valor '.
            'from resultado res INNER JOIN empresa e ON e.id = res.empresa_id '.                
            'WHERE e.cnpj = \'' .$cnpj. '\' and res.codigo_conta = \'' .$codigo_conta. '\' and YEAR(res.data) >= ' .$ano_ini. ' and MONTH(res.data) = 12 '.
            'UNION '.
            'select MAX(MONTH(res.data)) AS mes, YEAR(res.data) AS ano, res.valor '.
            'from resultado res INNER JOIN empresa e ON e.id = res.empresa_id '.                
            'WHERE e.cnpj = \'' .$cnpj. '\' and res.codigo_conta = \'' .$codigo_conta. '\' AND YEAR(res.data) = ' .$ano_atual. ' '.
            'GROUP BY ano, valor) tmp '.
            'ORDER BY ano, mes;';    
        $query = $this->db->query($vSQL, false);
        return $query->getResult();                
    }



    public function salvar_links_empresas($data){
        
        $this->builder = $this->builder('link_arquivo_empresa');
        if (!isset($data)) return 0;                
        
        //-- Verifica se existe resultado cadastrado
        $id = 0;
        $retorno = $this->get_LinkEmpresa($data['cnpj'], $data['data'], $data['versao']);
        if($retorno) {
            $data["id"] = $retorno->id;
            $id = $retorno->id;
        }
        
        if($id === 0){
            $this->insert($data);
            return $this->insertID();            
        }
        else{
            $this->builder->where('id', $id)
                          ->update($data); 
            return $id; 
        }        
    }   
    


    public function setarFlagArquivoEmpresa($numero, $flag){
        
        if (!isset($numero)) return 0;                
        
        $this->builder = $this->builder('link_arquivo_empresa');
        $this->builder->set('importado', $flag)
                      ->where('numero', $numero)
                      ->update();
    }   

    
    
    
    public function get_LinkEmpresa($cnpj, $data, $versao){
        
        $this->builder = $this->builder('link_arquivo_empresa');
        return $this->where('cnpj', $cnpj)
                    ->where('data', $data)
                    ->where('versao', $versao)
                    ->first();
    }  


    public function get_LinkEmpresaCnpj($cnpj){
        
        $this->builder = $this->builder('link_arquivo_empresa');
        return $this->select('numero, data, versao')
                    ->where('cnpj', $cnpj)                        
                    ->where('importado', '0')                        
                    ->orderBy('data, versao')
                    ->findAll();
    }   

    public function get_AnosCadastradosEmpresaCnpj($cnpj){
        
        $this->builder = $this->builder('link_arquivo_empresa');
        return $this->select('year(data) as ano')
                      ->distinct()
                      ->where('cnpj', $cnpj)                        
                      ->where('importado', '0')                        
                      ->orderBy('ano')
                      ->findAll();       
    }  


    public function getListNumeroEmpresas($ano){
        
        $vSQL = 
            'select cnpj, MAX(numero) AS numero, MAX(versao) AS versao '.
            'FROM link_arquivo_empresa '.
            'WHERE `data` >="' .$ano. '-01-01" and `data` <="' .$ano. '-31-12" '.
            'GROUP BY cnpj;';

        $query = $this->db->query($vSQL, false);
        return $query->getResult();   
    }  
    
    

    public function get_ListaNumerosArquivos($cnpj, $ini, $fim, $tipo = 'anual'){
        
        $this->builder = $this->builder('link_arquivo_empresa');
        if($tipo === 'anual') $this->where('MONTH(DATA)', '12');
        if($tipo === 'trimestral') $this->where('MONTH(DATA) <> ', '12');

        return $this->select('numero, data, versao')
                    ->where('cnpj', $cnpj)                        
                    ->where('importado', '0')                        
                    ->where('data >=', ($ini . '-01-01'))                        
                    ->where('data <=', ($fim . '-12-31'))
                    ->orderBy('versao')
                    ->findAll();
    } 



//$compiled = $this->builder->getCompiledSelect();    
}