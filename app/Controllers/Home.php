<?php

namespace App\Controllers;

class Home extends BaseController{
	
	public function index(){
		return view('tables');
	}

	public function categoria(){
		echo view('categoria/list');
		//return view('/categoria/list');
	}
}
