<?php

namespace App\Http\Controllers;

use App\Marker;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $response = Marker::paginate(10);
        $response->withPath('/');

        return view('gmap', ['response' => $response]);
    }
}
