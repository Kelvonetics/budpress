<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Permission as PermissionResource;
use Illuminate\Support\Facades\Input;

class PermissionController extends Controller
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
          $permissions = \App\Permission::with('department')->orderBy('name', 'asc')->get();
          return ['data'=>$permissions];         
        }
        else
        {
            $permissions = \App\Permission::with('department')->orderBy('name', 'asc')->paginate(15);
            return PermissionResource::collection($permissions);
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
        $permission = $request->isMethod('put') ? \App\Permission::findOrFail($request->permission_id) : new \App\Permission;

        if($request->isMethod('put') == true)
        {   
            $permission->id = $request->permission_id;
            $permission->name = $request->name;
            $permission->department_id = $request->department_id;
            $permission->constant = $request->constant;

            if($permission->save())
            {
                return new PermissionResource($permission);
            }
        }
        else
        {   
            $permission->name = $request->name;
            $permission->department_id = $request->department_id;
            $permission->constant = $request->constant;

            if($permission->save())
            {
                return new PermissionResource($permission);
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
        $permission = \App\Permission::findOrFail($id);
        return new PermissionResource($permission);
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
        $permission = \App\Permission::findOrFail($id);
        if($permission->delete())
        {
            return new PermissionResource($permission);
        }
    }


    

    public function AssignPermission(Request $request)
    {
        $roles = \App\Role::orderBy('name', 'asc')->get();
        $categories = \App\Department::orderBy('name', 'asc')->get();
        return view('permission.assign-permissions', compact('roles', 'categories')); 
    }



    public function getConstants(Request $request)
    {
        $constant_data = \App\Permission::where('department_id', $request->department_id)->get();
        return response()->json($constant_data);
    }


    public function AssignPermissionToRole(Request $request)
    { 
        // return $request->all();
      try
      {
        //   $p = $request->input('permission_list');
          $no_of_permissions = count($request->input('permission_list'));
          $role = \App\Role::find($request->perm_role_id);
          $perms = \App\Permission::where('department_id', $request->input('cate_id'))->pluck('id');
          $role->permission()->detach($perms);

            if($no_of_permissions > 0)
            {
              for ($i=0; $i < $no_of_permissions; $i++) 
              {
                $role->permission()->attach($request->permission_list[$i], ['created_at' => date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
              } 
            }

            // if($no_of_permissions > 0)
            // {
            //   for ($i=1; $i <= $no_of_permissions; $i++) 
            //   {
            //     $add = \App\PermissionRole::create
            //     ([               
            //         'permission_id' => $request->perm_.$i,
            //         'role_id' => $request->perm_role_id,
            //     ]);
            //     // $request->input('perm_'.$i.'');
            //   } 
            // }

         return redirect()->route('assign-permission')->with('info', 'Permissions and Privileges Assign To Role Successfully');
      }
      catch(\Exception $e)
      {
          return  redirect()->route('assign-permission')->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
      }
        
    }
}

