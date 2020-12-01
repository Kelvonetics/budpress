<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Expense as ExpenseResource;

class ExpenseController extends Controller
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
          $expenses = \App\Expense::with(['imprest', 'action'])->orderBy('id', 'desc')->get();
          return ['data'=>$expenses];         
        }
        else
        {
            $expenses = \App\Expense::with(['imprest', 'action'])->orderBy('id', 'desc')->paginate(15);
            return ExpenseResource::collection($expenses);
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
        $expense = $request->isMethod('put') ? \App\Expense::findOrFail($request->expense_id) : new \App\Expense;

        if($request->isMethod('put') == true)
        {    
            if($request->actions == '')
            { 
                $expense->id = $request->expense_id;
                $expense->name = $request->name;
                $expense->purpose = $request->purpose;
                $expense->workflow_id = $request->workflow_id;
                $expense->imprest_id = $request->imprest_id;
                $expense->type_id = $request->type_id;
                $expense->amount = $request->amount;
                $expense->propose_date = date('Y-m-d', strtotime($request->propose_date));
                $expense->year = $request->year;
                $expense->status_id = $request->status_id;
            }  
            else
            { 
                $expense->id = $request->expense_id;
                $expense->name = $request->name;
                $expense->purpose = $request->purpose;
                $expense->workflow_id = $request->workflow_id;
                $expense->imprest_id = $request->imprest_id;
                $expense->type_id = $request->type_id;
                $expense->amount = $request->amount;
                $expense->propose_date = date('Y-m-d', strtotime($request->propose_date));
                $expense->year = $request->year;
                $expense->status_id = $request->status_id;
                $expense->flow_stage_id = $request->actions + 1;
                $expense->actions = $request->actions;
            }            

            if($expense->save())
            {
                //track history
                if($request->actions == ''){ $Action = 'Update'; }  
                elseif($request->actions == 2) { $Action = 'Review'; }
                elseif($request->actions == 3) { $Action = 'Approve'; }
                $history = new \App\TrackHistory;

                $history->history_name = 'Expense';
                $history->action_name_id = $expense->id;
                $history->action = $Action;
                $history->created_by = 2;  

                if($history->save())
                {
                    //UPDATE IMPREST BALANCE
                    $imprest = \App\Imprest::findOrFail($request->imprest_id);
                    $balance = $imprest->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Imprest::where('id', $request->imprest_id)->update($data);
                    
                    //UPDATE BUDGET BALANCE
                    $budget = \App\Budget::findOrFail($imprest->budget_id);
                    $balance = $budget->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Budget::where('id', $imprest->budget_id)->update($data);

                    return new ExpenseResource($expense);
                } 
            }
        }
        
        else
        {            
            $expense->name = $request->name;
            $expense->purpose = $request->purpose;
            $expense->workflow_id = $request->workflow_id;
            $expense->imprest_id = $request->imprest_id;
            $expense->type_id = $request->type_id;
            $expense->amount = $request->amount;
            $expense->propose_date = date('Y-m-d', strtotime($request->propose_date));
            $expense->year = $request->year;
            $expense->status_id = $request->status_id;
            $expense->created_by = 1;

            if($expense->save())
            {
                //track history
                $history = new \App\TrackHistory;

                $history->history_name = 'Expense';
                $history->action_name_id = $expense->id;
                $history->action = 'Create';
                $history->created_by = 2;  

                if($history->save())
                {
                    //UPDATE IMPREST BALANCE
                    $imprest = \App\Imprest::findOrFail($request->imprest_id);
                    $balance = $imprest->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Imprest::where('id', $request->imprest_id)->update($data);
                    
                    //UPDATE BUDGET BALANCE
                    $budget = \App\Budget::findOrFail($imprest->budget_id);
                    $balance = $budget->balance - $request->amount;
                    $data = array
                    (
                        'balance' => $balance, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Budget::where('id', $imprest->budget_id)->update($data);
                        
                    //update position
                    $position = \App\Flow::where('workflow_id', $request->workflow_id)->where('position', 2)->first();
                    $data = array
                    (
                        'flow_stage_id' => $position->position, 'updated_at' => date('Y-m-d h:i:s')
                    );
                    \App\Expense::where('id', $expense->id)->update($data);

                    return new ExpenseResource($expense);
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
        $expense = \App\Expense::findOrFail($id);
        return new ExpenseResource($expense);
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
        $expense = \App\Expense::findOrFail($id);
        if($expense->delete())
        {
            return new ExpenseResource($expense);
        }
    }
}
