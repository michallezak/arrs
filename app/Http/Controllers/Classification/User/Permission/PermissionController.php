<?php

namespace App\Http\Controllers\Classification\User\Permission;

use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['page_title'] = 'Užívatelské práva';
        $data['layout_options'] = 'sidebar-collapse';

        $data['permissions'] = \App\Permission::all();

        return view('classification.user.permission')->with($data);
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

        $enumerationValue = new Permission;
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
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
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

        $enumerationValue = Permission::find($request->id);

        $enumerationValue->display_name = $request->display_name;
        $enumerationValue->description = $request->description;
        $enumerationValue->save();

        return redirect()->back()
            ->with('message','Uložené');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }
}
