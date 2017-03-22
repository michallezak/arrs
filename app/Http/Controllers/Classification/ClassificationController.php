<?php

namespace App\Http\Controllers\Classification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassificationController extends Controller
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
        $data['page_title'] = 'Číselníky';
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Užívatelia',
                'url' => '/users',
                'color' => 'bg-red',
                'ion' => 'ion-person-add'
            ]
        ];

        return view('classification.classification')->with($data);
    }
}
