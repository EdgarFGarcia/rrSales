<?php

namespace App\Http\Controllers;
use GuzzleHttp\Client;
use Auth;

use Illuminate\Http\Request;

class apiController extends Controller
{
    //
    public function getJsonData(Request $request){
        // return $request->all();
        $client = new \GuzzleHttp\Client();

        $params = [
            'query' => [
                'view' => $request->view,
                'pivotColumn' => $request->pivotColumn,
                'pivotRow' => $request->pivotRow,
                'pivotSourceCol' => $request->pivotSourceCol,
                'client' => $request->client,
                'key' => $request->key,
                'filter' => $request->filter
            ]
        ];

        return $response = $client->request('GET', 'http://oxford.doccsonline.com/DataViewer/iDoXsInsightGetJSONChartData.php', $params);

    }

    public function index(){
        return view('login');
    }

    

    public function login(Request $r){
        // return bcrypt('password');
        // return $r->all();

        $validateData = $r->validate([

            'username' => 'required|string',
            'password' => 'required|string'

        ]);

        Auth::attempt([
            'username' => $r->username,
            'password' => $r->password
        ]);

        if(Auth::check()){
            return redirect()->intended('/main');
        }else{
            return redirect('/');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

}
