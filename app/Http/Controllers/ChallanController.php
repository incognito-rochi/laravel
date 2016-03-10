<?php

namespace App\Http\Controllers;
use DB;


class ChallanController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
       $result = DB::table('products')->get(); 
        return view('challan.index')->with('data',$result);
    }

}
