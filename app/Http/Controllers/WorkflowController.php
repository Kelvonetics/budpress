<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Workflow as WorkflowResource;

class WorkflowController extends Controller
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
          $workflows = \App\Workflow::orderBy('id', 'desc')->get();
          return ['data'=>$workflows];         
        }
        else
        {
            $workflows = \App\Workflow::orderBy('id', 'desc')->paginate(15);
            return WorkflowResource::collection($workflows);
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
        $workflow = $request->isMethod('put') ? \App\Workflow::findOrFail($request->workflow_id) : new \App\Workflow;

        if($request->isMethod('put') == true)
        {   
            $workflow->id = $request->workflow_id;
            $workflow->name = $request->name;

            if($workflow->save())
            {
                return new WorkflowResource($workflow);
            }
        }
        else
        {            
            $workflow->name = $request->name;
            $workflow->created_by = 1;

            if($workflow->save())
            {
                return new WorkflowResource($workflow);
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
        $workflow = \App\Workflow::findOrFail($id);
        return new WorkflowResource($workflow);
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
        $workflow = \App\Workflow::findOrFail($id);
        if($workflow->delete())
        {
            return new WorkflowResource($workflow);
        }
    }
}
