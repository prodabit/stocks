<?php

namespace App\Models;
use CodeIgniter\Model;

class PermissoesModel extends Model {

    protected $table = 'permissao_usuario';
    protected $returnType = 'object';
    protected $allowedFields = ['id', 'usuario_id', 'menu_id', 'ativo', 'nome'];

    public function get_permissao($id = 0, $usuario_id = 0){
        
        if ($id > 0){
            return $this->where('id', $id)
                        ->orderBy('id', 'desc')
                        ->findAll();
        }
        
        if($usuario_id > 0){
            
            $vSQL = 
                'select menu.id, menu.descricao, menu.ativo, menu.flggrupo, 
                ifnull((select menu_id FROM permissao_usuario p WHERE p.menu_id = menu.id AND p.usuario_id = '.$usuario_id.'),0) AS checked
                from menu;'; 
            $query = $this->db->query($vSQL, false);
            return $query->getResult();    
            
            //$compiled = $builder->getCompiledSelect(); 
            //return $compiled;    
        }
        
    }     


    public function get_usuarios($id = 0){
        
        $builder = $this->builder('usuario');
        $builder->select('id, nome')
                ->where('ativo <>', '2')
                ->orderBy('nome', 'asc');

        if ($id > 0){
            $builder->where('id = ', $id);
        }
        $query = $builder->get();
        return $query->getResult();  // returns an array of objects                     
    }        
    
    

    
    public function salvar($data){

        $menu_ids = explode(',', $data['menu_ids']);
        $usuario_id = $data['usuario_id'];
        $usuario_source_id = $data['usuario_source_id'];

        //-- Apaga todos os registros para o usuário 
        $vSQL = 'delete from permissao_usuario where usuario_id = ' .$usuario_id;
        $this->db->query($vSQL);
        //return $this->db->affectedRows();

        //-- Caso tenha enviado o usuario_source_id, copia todas as suas configurações
        //-- para o usuário que está sendo alterado
        if(isset($usuario_source_id) && $usuario_source_id > 0){
            $vSQL = 'insert into permissao_usuario(usuario_id, menu_id, ativo) '.
                    'select ' .$usuario_id. ', menu_id, \'1\' from permissao_usuario '.
                    'where usuario_id = ' .$usuario_source_id;
        }        
        else{
            $vSQL = ''; 
            if(count($menu_ids) === 1 and $menu_ids[0] === '') return 1;
            
            foreach($menu_ids as $menu_id){
                if($vSQL !== '') $vSQL .= ',';
                $vSQL .= '(' .$usuario_id. ',' .$menu_id .')';
            }
            $vSQL = 'insert into permissao_usuario(usuario_id, menu_id) values' .$vSQL; 
        }
        $this->db->query($vSQL);
        return $this->db->affectedRows();
    }   
}