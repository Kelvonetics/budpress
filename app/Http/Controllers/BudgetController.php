<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Budget as BudgetResource;
use App\Http\Resources\Imprest as ImprestResource;
use App\Http\Resources\TrackHistory as TrackHistoryResource;

class BudgetController extends Controller
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
            $budgets = \App\Budget::with(['workflow', 'department', 'action'])->orderBy('id', 'desc')->get();
            return ['data'=>$budgets];         
        }
        else
        {
            $budgets = \App\Budget::with(['workflow', 'department', 'action'])->orderBy('id', 'desc')->paginate(15);
            // $imprest[] = 0;
            // foreach($budgets as $budget)
            // {
            //     $imprest[] = \App\Imprest::where('budget_id', $budget->id)->first();                
            // }
            // // $imprest;
            // return ['data'=>$budgets, 'imprest'=>$imprest]; 
            return BudgetResource::collection($budgets);
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
        // return $request->all();
        $budget = $request->isMethod('put') ? \App\Budget::findOrFail($request->budget_id) : new \App\Budget;       

        if($request->isMethod('put') == true)
        {    
            if($request->actions == '')
            { 
                $budget->id = $request->budget_id;
                $budget->name = $request->name;
                $budget->description = $request->description;
                $budget->type_id = $request->type_id;
                $budget->department_id = $request->department_id;
                $budget->amount = $request->amount;
                $budget->year = $request->year;
                $budget->end_date = $request->end_date;
                $budget->balance = $request->balance;
                $budget->workflow_id = $request->workflow_id;
            }  
            else
            { 
                $budget->id = $request->budget_id;
                $budget->name = $request->name;
                $budget->description = $request->description;
                $budget->type_id = $request->type_id;
                $budget->department_id = $request->department_id;
                $budget->amount = $request->amount;
                $budget->year = $request->year;
                $budget->end_date = $request->end_date;
                $budget->balance = $request->balance;
                $budget->workflow_id = $request->workflow_id;
                $budget->flow_stage_id = $request->actions + 1;
                $budget->actions = $request->actions;
            }            

            if($budget->save())
            {
                //track history
                if($request->actions == ''){ $Action = 'Update'; }  
                elseif($request->actions == 2) { $Action = 'Review'; }
                elseif($request->actions == 3) { $Action = 'Approve'; }
                $history = new \App\TrackHistory;

                $history->history_name = 'Budget';
                $history->action_name_id = $budget->id;
                $history->action = $Action;
                $history->created_by = 2;  

                if($history->save())
                {
                    //UPDATE NO OF FLOWS
                    return new BudgetResource($budget);
                } 
            }
        }
        else
        {            
            $budget->name = $request->name;
            $budget->description = $request->description;
            $budget->type_id = $request->type_id;
            $budget->department_id = $request->department_id;
            $budget->amount = $request->amount;
            $budget->balance = $request->amount;
            $budget->year = $request->year;
            $budget->end_date = date('Y-m-d', strtotime($request->end_date));
            $budget->workflow_id = $request->workflow_id;

            if($budget->save())
            {
                //track history
                $history = new \App\TrackHistory;

                $history->history_name = 'Budget';
                $history->action_name_id = $budget->id;
                $history->action = 'Create';
                $history->created_by = 2;  

                if($history->save())
                {
                    //UPDATE NO OF FLOWS
                    $workflow_count = \App\Flow::where('workflow_id', $request->workflow_id)->count();
                    $no_of_flows = $workflow_count;
                    $data = array
                    (
                        'no_of_flows' => $workflow_count, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Workflow::where('id', $request->workflow_id)->update($data);
                    
                    //update position
                    $position = \App\Flow::where('workflow_id', $request->workflow_id)->where('position', 2)->first();
                    $data = array
                    (
                        'flow_stage_id' => $position->position, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Budget::where('id', $budget->id)->update($data);
                    return new BudgetResource($budget);
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
        $budget = \App\Budget::findOrFail($id);
        return new BudgetResource($budget);
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
        $budget = \App\Budget::findOrFail($id);
        if($budget->delete())
        {
            return new BudgetResource($budget);
        }
    }

    
    public function getBalance(Request $request)
    {
        //
        $budgets = \App\Budget::orderBy('id', 'desc')->get(); 
        $imprest[] = 0;
        foreach($budgets as $budget)
        {
            $imprest[] = \App\Imprest::where('budget_id', $budget->id)->first();                
        }
        // $imprest;
        return ['data' => $imprest];   
    }






    //get Budget imprest
    function budgetImprests($id, Request $request)
    {
        if ($request->filled('all'))
        {
            $budget_imprests = \App\Imprest::with(['budget', 'workflow', 'department', 'action'])->where('id', $id)->orderBy('id', 'desc')->get();
            return ImprestResource::collection($budget_imprests);         
        }
        else
        {
            $budget_imprests = \App\Imprest::with(['budget', 'workflow', 'department', 'action'])->where('id', $id)->orderBy('id', 'desc')->paginate(15);
            return ImprestResource::collection($budget_imprests);
        }
    }
}
