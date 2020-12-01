<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Flow as FlowResource;

class FlowController extends Controller
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
            $flows = \App\Flow::with(['workflow', 'user', 'action'])->orderBy('id', 'desc')->get();
            return ['data'=>$flows];         
        }
        else
        {
            $flows = \App\Flow::with(['workflow', 'user', 'action'])->orderBy('id', 'desc')->paginate(15); 
            return FlowResource::collection($flows);
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
        $flow = $request->isMethod('put') ? \App\Flow::findOrFail($request->flow_id) : new \App\Flow;

        if($request->isMethod('put') == true)
        {   
            $flow->id = $request->flow_id;
            $flow->name = $request->name;
            $flow->workflow_id = $request->workflow_id;
            $flow->action_id = $request->action_id;
            $flow->position = $request->position;
            $flow->user_role_id = $request->user_role_id;

            if($flow->save())
            {
                $workflow_count = \App\Flow::where('workflow_id', $request->workflow_id)->count();
                $no_of_flows = $workflow_count;
                $data = array
                (
                    'no_of_flows' => $workflow_count, 'updated_at' => date('Y-m-d h:i:s')
                );
                \App\Workflow::where('id', $request->workflow_id)->update($data);

                return new FlowResource($flow);
            }
        }
        else
        {            
            $flow->name = $request->name;
            $flow->workflow_id = $request->workflow_id;
            $flow->action_id = $request->action_id;
            $flow->position = $request->position;
            $flow->user_role_id = $request->user_role_id;
            $flow->created_by = 1;

            if($flow->save())
            {
                //track history
                $history = new \App\TrackHistory;

                $history->history_name = 'Flow';
                $history->action_name_id = $flow->id;
                $history->action = 'Create';
                $history->created_by = 2;  

                if($history->save())
                {
                    $workflow_count = \App\Flow::where('workflow_id', $request->workflow_id)->count();
                    $no_of_flows = $workflow_count;
                    $data = array
                    (
                        'no_of_flows' => $workflow_count, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Workflow::where('id', $request->workflow_id)->update($data);

                    return new FlowResource($flow);
                }                 
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
        $flow = \App\Flow::findOrFail($id);
        return new FlowResource($flow);
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
        $flow = \App\Flow::findOrFail($id);
        if($flow->delete())
        {
            return new FlowResource($flow);
        }
    }
}
