<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Imprest as ImprestResource;
use App\Http\Resources\Expense as ExpenseResource;

class ImprestController extends Controller
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
          $imprests = \App\Imprest::with(['budget', 'workflow', 'department', 'action'])->orderBy('id', 'desc')->get();
          return ['data'=>$imprests];         
        }
        else
        {
            $imprests = \App\Imprest::with(['budget', 'workflow', 'department', 'action'])->orderBy('id', 'desc')->paginate(15);
            return ImprestResource::collection($imprests);
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
        $imprest = $request->isMethod('put') ? \App\Imprest::findOrFail($request->imprest_id) : new \App\Imprest;

        if($request->isMethod('put') == true)
        {    
            if($request->actions == '')
            { 
                $imprest->id = $request->imprest_id;
                $imprest->name = $request->name;
                $imprest->description = $request->description;
                $imprest->workflow_id = $request->workflow_id;
                $imprest->budget_id = $request->budget_id;
                $imprest->type_id = $request->type_id;
                $imprest->department_id = $request->department_id;
                $imprest->amount = $request->amount;
                $imprest->year = $request->year;
                $imprest->start_date = date('Y-m-d', strtotime($request->start_date));
                $imprest->end_date = date('Y-m-d', strtotime($request->end_date));
                $imprest->status_id = $request->status_id;
            }  
            else
            { 
                $imprest->id = $request->imprest_id;
                $imprest->name = $request->name;
                $imprest->description = $request->description;
                $imprest->workflow_id = $request->workflow_id;
                $imprest->budget_id = $request->budget_id;
                $imprest->type_id = $request->type_id;
                $imprest->department_id = $request->department_id;
                $imprest->amount = $request->amount;
                $imprest->year = $request->year;
                $imprest->start_date = date('Y-m-d', strtotime($request->start_date));
                $imprest->end_date = date('Y-m-d', strtotime($request->end_date));
                $imprest->status_id = $request->status_id;
                $imprest->flow_stage_id = $request->actions + 1;
                $imprest->actions = $request->actions;
            }            

            if($imprest->save())
            {
                //track history
                if($request->actions == ''){ $Action = 'Update'; }  
                elseif($request->actions == 2) { $Action = 'Review'; }
                elseif($request->actions == 3) { $Action = 'Approve'; }
                $history = new \App\TrackHistory;

                $history->history_name = 'Imprest';
                $history->action_name_id = $imprest->id;
                $history->action = $Action;
                $history->created_by = 2;  

                if($history->save())
                {
                    //UPDATE Budget Balance
                    $budget = \App\Budget::findOrFail($request->budget_id);
                    $balance = $budget->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Budget::where('id', $request->budget_id)->update($data);

                    return new ImprestResource($imprest);
                } 
            }
        }
        else
        {            
            $imprest->name = $request->name;
            $imprest->description = $request->description;
            $imprest->workflow_id = $request->workflow_id;
            $imprest->budget_id = $request->budget_id;
            $imprest->type_id = $request->type_id;
            $imprest->department_id = $request->department_id;
            $imprest->amount = $request->amount;
            $imprest->balance = $request->amount;
            $imprest->year = $request->year;
            $imprest->start_date = date('Y-m-d', strtotime($request->start_date));
            $imprest->end_date = date('Y-m-d', strtotime($request->end_date));
            $imprest->status_id = $request->status_id;
            $imprest->created_by = 1;

            if($imprest->save())
            {
                //track history
                if($request->actions == ''){ $Action = 'Update'; }  
                elseif($request->actions == 2) { $Action = 'Review'; }
                elseif($request->actions == 3) { $Action = 'Approve'; }
                $history = new \App\TrackHistory;

                $history->history_name = 'Imprest';
                $history->action_name_id = $imprest->id;
                $history->action = $Action;
                $history->created_by = 2; 
                
                if($history->save())
                {
                    $budget = \App\Budget::findOrFail($request->budget_id);
                    $balance = $budget->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Budget::where('id', $request->budget_id)->update($data);
                        
                    //update position
                    $position = \App\Flow::where('workflow_id', $request->workflow_id)->where('position', 2)->first();
                    $data = array
                    (
                        'flow_stage_id' => $position->position, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Imprest::where('id', $imprest->id)->update($data);

                    return new ImprestResource($imprest);
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
        $imprest = \App\Imprest::findOrFail($id);
        return new ImprestResource($imprest);
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
        $imprest = \App\Imprest::findOrFail($id);
        if($imprest->delete())
        {
            return new ImprestResource($imprest);
        }
    }

    



    //get Budget imprest Expenses
    function budgetImprestExpenses($id, Request $request)
    {
        if ($request->filled('all'))
        {
            $budget_imprest_expenses = \App\Expense::with(['imprest', 'action'])->where('id', $id)->orderBy('id', 'desc')->get();
            return ExpenseResource::collection($budget_imprest_expenses);         
        }
        else
        {
            $budget_imprest_expenses = \App\Expense::with(['imprest', 'action'])->where('id', $id)->orderBy('id', 'desc')->paginate(15);
            return ExpenseResource::collection($budget_imprest_expenses);
        }
    }
}
