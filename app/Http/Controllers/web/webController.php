<?php

namespace App\Http\Controllers\web;

use App\Charter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class webController extends Controller
{
    public $charter;

    public function __construct(Charter $charter) {
		$this->$charter =$charter;
    }
    
    public function index(  ){
	    $url = '';
	    $queryString = Request()->getQueryString();
	    if ( $queryString ) {
		    $url .= '?' . $queryString;
	    }

        return view('web.index', compact('url'));
 
    }
}
