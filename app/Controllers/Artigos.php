<?php

namespace App\Controllers;
use App\Models\ArtigosModel;

class Artigos extends BaseController{

    public function fundos_imobiliarios(){
		
        $id = 1;
        $model = new ArtigosModel();
        $data["artigo"] = $model->get_artigo($id);
        echo view('artigos/page', $data);		
	}
}
