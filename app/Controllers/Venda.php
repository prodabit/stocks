<?php

namespace App\Controllers;
use App\Models\ProcardsModel;

class Venda extends BaseController{

    protected $helpers = ['prodabit'];

    public function pdv(){  
		  echo view('vendas/pdv_touch');		
	  }

    public function teste(){
      echo view('vendas/teste');		
    }
}
