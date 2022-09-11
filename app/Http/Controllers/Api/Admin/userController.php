<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class userController extends Controller
{
    public function index(){
     $user= Admin::get();
      return response()->json($user);
    }
 }
 
