<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AgencyController extends MasterController
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index()
    {
        $data = [
            'page_title' 	          => "Agenda de citas"
            ,'title'  		          => "Agenda"
        ];
        return $this->_loadView( 'salesOfPoint.orders', $data );
    }
}
