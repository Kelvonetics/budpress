<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TrackHistory as TrackHistoryResource;

class TrackHistoryController extends Controller
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
            $track_histories = \App\TrackHistory::orderBy('id', 'desc')->get();
            return ['data'=>$track_histories];         
        }
        else
        {
            $track_histories = \App\TrackHistory::orderBy('id', 'desc')->paginate(15);
            return TrackHistoryResource::collection($track_histories);
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
        $track_history = new \App\TrackHistory;
  
            $track_history->id = $request->track_history_id;
            $track_history->history_name = 'Budget';
            $track_history->action_name_id = $request->action_name_id;
            $track_history->action = 'Approve';
            $track_history->created_by = 2;

            if($track_history->save())
            {
                return new TrackHistoryResource($track_history);
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
        $track_history = \App\TrackHistory::findOrFail($id);
        return new TrackHistoryResource($track_history);
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
        $track_history = \App\TrackHistory::findOrFail($id);
        if($track_history->delete())
        {
            return new TrackHistoryResource($track_history);
        }
    }

    


public function approveBudget(Request $request)
{
    try
    {    
        //INSERTING NEW EXTERNAL USER
        $approve = \App\TrackHistory::updateOrCreate
        (['id'=> $request->id],
        [   
             'action_name_id' => $request->action_name_id,
        ]);

        if($request->ajax())
         {   
             return response()->json(['status'=>'ok', 'info'=>'Budget Was Approved Successfully.']);
         }
         else
         {
            return redirect()->back()->with('info', 'Budget Was Approved Successfully.');
         }
    }
    catch (\Exception $e) 
    {
        return  redirect()->back()->with('error', 'Sorry, An Error Occurred Please Try Again. ' .$e->getMessage());
    }

}
}
