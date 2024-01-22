<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TestRequest;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }
    public function getForm(){
        return view('client.product');
    }
    public function addProduct(TestRequest $request){
        return response()->json(['status'=>'success']);
    }
}
