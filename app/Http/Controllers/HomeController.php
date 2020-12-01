<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public $date;
    public $first_day;
    public $last_day;


    public function __construct()
    {
        // $this->middleware('auth');

        $this->date = date('Y-m-d'); 
        $this->first_day = date('Y-m-01', strtotime($this->date));
        $this->last_day = date('Y-m-t', strtotime($this->date)); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
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





    // public function users()
    // {
    //     return view('users');
    // }



    public function about()
    {
        return view('about');
    }

    


    public function getExams()
    {
        $exams = \App\ExamUser::where('date', $this->date)->distinct()->count('id'); 
        return ['count_exams'=>$exams];
    }

    public function completedExams()
    {
        $exams_completed = \App\ExamUser::where('date', $this->date)->where('status_id', 1)->distinct()->count('id'); 
        return ['completed_exams'=>$exams_completed];
    }

    public function totalLiveExams()
    {
        $total_live_exams = \App\ExamUser::where('status_id', 1)->distinct()->count('exam_id');
        $fetch_live_exams = \App\ExamUser::where('status_id', 1)->distinct('exam_id')->pluck('exam_id')->toArray();
        $live_exam_details = \App\ExamType::whereIn('id', $fetch_live_exams)->get();
        return ['all_live_exams'=>$total_live_exams, 'live_exam_details'=>$live_exam_details];
    }

    public function totalExamUsers()
    {
        $exam_users = \App\ExamUser::where('date', $this->date)->count();
        return ['all_exam_users'=>$exam_users];
    }

    public function finishedUsers()
    {
        $users_finished = \App\ExamUser::where('date', $this->date)->where('status_id', 0)->count();  
        return ['all_finished_users'=>$users_finished];
    }

    public function totalLiveUsers()
    {
        $live_user_chart = $total_live_users = \App\ExamUser::where('status_id', 1)->distinct()->count('id'); 
        return ['all_live_users'=>$total_live_users];
    }





}
