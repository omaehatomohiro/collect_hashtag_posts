<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hash;

class HashController extends Controller
{

    public function store(Request $request){
        $hash = new Hash();
        $hash->name = $request->hash_name;
        $hash->save();
        return redirect('/');
    }

}
