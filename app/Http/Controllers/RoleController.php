<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Role as RoleResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //
        if ($request->filled('all'))
        {
          $roles = \App\Role::orderBy('name', 'asc')->get();
          return ['data'=>$roles];         
        }
        else
        {
            $roles = \App\Role::orderBy('name', 'asc')->paginate(15);
            return RoleResource::collection($roles);
        }
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
        $role = $request->isMethod('put') ? \App\Role::findOrFail($request->role_id) : new \App\Role;

        if($request->isMethod('put') == true)
        {   
            $role->id = $request->role_id;
            $role->name = $request->name;
            $role->description = $request->description;
            if($role->save())
            {
                return new RoleResource($role);
            }
        }
        else
        {   
            $role->name = $request->name;
            $role->description = $request->description;
            if($role->save())
            {
                return new RoleResource($role);
            }            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $role = \App\Role::findOrFail($id);
        return new RoleResource($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $role = \App\Role::findOrFail($id);
        if($role->delete())
        {
            return new RoleResource($role);
        }
    }
}
