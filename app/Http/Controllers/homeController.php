<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Parametro;
use Illuminate\Support\Facades\DB;


class homeController extends Controller
{
    //

    public function __construct()     {
        //$parametros = DB::table('parametros')->get();
        //$items = DB::table('menus')->orderBy('posicion','ASC')->get();
        //print_r( $items);
    }
    public function index(){

        $parametros = DB::table('parametros')->get();
        $items = DB::table('menus')
                ->orderBy('subMenu')
                ->get();
        //print_r( $items);
        return view("home.index",compact('parametros','items'));


    }
    
}
