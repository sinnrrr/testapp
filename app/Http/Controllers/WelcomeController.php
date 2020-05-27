<?php

namespace App\Http\Controllers;

use App\Marker;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
<<<<<<< Updated upstream
    public function index() {
        $response = Marker::paginate(10);
        $response->withPath('/');

        return view('gmap', ['response' => $response]);
=======
    public function index(Request $request) {
        $response = Marker::paginate(10);
        $response->withPath('/');

        if ($request->ajax()) {
            return view('gmap', compact('response'));
        }

        return view('index',compact('response'));
>>>>>>> Stashed changes
    }
}
