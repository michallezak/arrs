<?php

namespace App\Http\Controllers\Classification\User;

use App\User;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Užívatelia';
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Užívatelské role',
                'url' => '/role',
                'color' => 'bg-aqua',
                'ion' => 'ion-ios-keypad'
            ],
            [
                'menu_name' => 'Užívatelské práva',
                'url' => '/permission',
                'color' => 'bg-green',
                'ion' => 'ion-checkmark-round'
            ]
        ];
        $data['roles'] = "";

        $data['users'] = \App\User::all();

        return view('classification.user.user')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id, User $user)
    {
        $data['page_title'] = 'Užívatelia';
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Užívatelské role',
                'url' => '/role',
                'color' => 'bg-aqua',
                'ion' => 'ion-ios-keypad'
            ],
            [
                'menu_name' => 'Užívatelské práva',
                'url' => '/permission',
                'color' => 'bg-green',
                'ion' => 'ion-checkmark-round'
            ]
        ];

        $data['users'] = \App\User::all();
        $data['user_akt'] = \App\User::find($id);
        $data['cnt'] = 0;
        $data['roles'] = \App\Role::all()->sortBy('description');
        $data['user_role'] = \App\User::allRole($id);

        return view('classification.user.user')->with($data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateRole($id, Request $request, User $user)
    {
        $user = User::find($id);
        $user->detachAllRole();
        for($i=0;$i<$request->cnt;$i++){
            $role = Role::find($request->{'id'.$i});
            $user->attachRole($role);
        }
        return redirect()->back()
            ->with('message','Uložené');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
