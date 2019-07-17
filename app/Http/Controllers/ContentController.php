<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ContentController extends Controller
{
    public function users()
    {
        $data =  User::all();

        return view('userInfo',['users'=>$data]);
    }
}
