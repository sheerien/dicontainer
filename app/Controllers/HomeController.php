<?php
namespace App\Controllers;

use Dic\Container\HTTP\Request;


class HomeController extends Controller
{

    public function __construct(Request $request)
    {
    
    }
    public function index()
    {
        dd($this->request->method());
        echo "Home Controller ";
        // return view('home');
        // return var_dump(app()); 
    }
}