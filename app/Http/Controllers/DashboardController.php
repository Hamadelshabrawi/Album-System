<?php

namespace App\Http\Controllers;

use App\Models\Albums;
use App\Models\Pictures;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

     public function index(){
         $albums = Albums::all()->count();
         $pict = Pictures::all()->count();
         $user = User::all()->count();

         return view('panel.index',compact('albums','pict','user'));
     }

}
