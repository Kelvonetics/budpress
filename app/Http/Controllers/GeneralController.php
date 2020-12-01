<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\State as StateResource;
use App\Http\Resources\Action as ActionResource;
use App\Http\Resources\Classed as ClassedResource;
use App\Http\Resources\Designation as DesignationResource;
use App\Http\Resources\Session as SessionResource;
use App\Http\Resources\Student as StudentResource;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    }


    public function states()
    {
        $states = \App\State::orderBy('state_name', 'asc')->get();
        return StateResource::collection($states);
    }

    public function actions()
    {
        $actions = \App\Action::orderBy('name', 'asc')->get();
        return ['data'=>$actions]; 
        // return ActionResource::collection($actions);
    }

    public function classed()
    {
        $classed = \App\Classed::orderBy('class_name', 'asc')->get();
        return ClassedResource::collection($classed);
    }

    public function designations()
    {
        $designations = \App\Designation::orderBy('designation_name', 'asc')->get();
        return DesignationResource::collection($designations);
    }

    public function sessions()
    {
        $sessions = \App\Session::orderBy('session_name', 'asc')->get();
        return SessionResource::collection($sessions);
    }

    public function yearBook()
    {
        $year_books = \App\Student::orderBy('session_id', 'desc')->paginate(10);
        return StudentResource::collection($year_books);
    }

    public function studentProfile(Request $request)
    {
        $student_profile = \App\Student::where('registration_no', $request->id)->first();
        return ['data '=> $student_profile];
    }

}
