<?php

namespace App\Http\Controllers;
use DB;


class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
       $result = DB::table('products')->get(); 
        return view('products.index')->with('data',$result);
    }

}
