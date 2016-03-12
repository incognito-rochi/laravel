<?php
/**
 * Created by PhpStorm.
 * User: Raisul Islam
 * Date: 11-Mar-16
 * Time: 11:55 PM
 */

namespace App\Http\Controllers;



class HomeController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index() {
        return view('home.index');
    }

}