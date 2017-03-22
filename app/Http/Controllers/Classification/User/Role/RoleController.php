<?php

namespace App\Http\Controllers\Classification\User\Role;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Užívatelské role';
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Užívatelské práva',
                'url' => '/permission',
                'color' => 'bg-green',
                'ion' => 'ion-checkmark-round'
            ]
        ];
        $data['roles'] = \App\Role::all();
        $data['permissions'] = "";
        return view('classification.user.role')->with($data);
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'display_name' => 'required|max:255'
        ]);
        //dd($request->all());
        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $except[] = '_token';

        $enumerationValue = new Role;
        $enumerationValue->name = $request->name;
        $enumerationValue->display_name = $request->display_name;
        $enumerationValue->description = $request->description;
        $enumerationValue->save();

        return redirect()->back()
            ->with('message','Pridané');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id, Role $role)
    {
        $data['page_title'] = 'Užívatelské role';
        $data['id'] = $id;
        $data['layout_options'] = 'sidebar-collapse';
        $data['items'] = [
            [
                'menu_name' => 'Užívatelské práva',
                'url' => '/permission',
                'color' => 'bg-green',
                'ion' => 'ion-checkmark-round'
            ]
        ];

        $data['roles'] = \App\Role::all();
        $data['role_akt'] = \App\Role::find($id);
        $data['cnt'] = 0;
        $data['permissions'] = \App\Permission::all()->sortBy('description');
        $data['permission_role'] = \App\Role::allPermission($id);

        return view('classification.user.role')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = \Validator::make($request->all(), [
            'display_name' => 'required|max:255'
        ]);
        //dd($request->all());
        if($validator->fails()){
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::find($request->id);

        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        return redirect()->back()
            ->with('message','Uložené');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function updatePermission($id, Request $request, Role $role)
    {

        $role = Role::find($id);
        $role->detachAllPermission();
        for($i=0;$i<$request->cnt;$i++){
            $permission = Permission::find($request->{'id'.$i});
            $role->attachPermission($permission);
        }
        return redirect()->back()
            ->with('message','Uložené');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
