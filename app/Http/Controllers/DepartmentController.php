<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Department as DepartmentResource;

class DepartmentController extends Controller
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
          $departments = \App\Department::orderBy('name', 'asc')->get();
          return ['data'=>$departments];         
        }
        else
        {
            $departments = \App\Department::orderBy('name', 'asc')->paginate(15);
            return DepartmentResource::collection($departments);
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
        $department = $request->isMethod('put') ? \App\Department::findOrFail($request->department_id) : new \App\Department;

        if($request->isMethod('put') == true)
        {   
            $department->id = $request->department_id;
            $department->name = $request->name;
            $department->description = $request->description;

            if($department->save())
            {
                return new DepartmentResource($department);
            }
        }
        else
        {            
            $department->name = $request->name;
            $department->description = $request->description;

            if($department->save())
            {

                return new DepartmentResource($department);
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
        $department = \App\Department::findOrFail($id);
        return new DepartmentResource($department);
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
        $department = \App\Department::findOrFail($id);
        if($department->delete())
        {
            return new DepartmentResource($department);
        }
    }
}
