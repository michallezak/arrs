<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Hlavné menu';
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Číselníky',
                'url' => '/classification',
                'color' => 'bg-red',
                'ion' => 'ion-ios-list-outline'
            ]
        ];

        return view('home')->with($data);
    }
}
