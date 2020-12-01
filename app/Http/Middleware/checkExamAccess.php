<?php

namespace App\Http\Middleware;

use Closure;

class checkExamAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {      
        $date = date('Y-m-d');
        // $exam_user = \App\ExamUser::where('exam_id', $request->exam_id)->where('email', $request->email)->where('code', $request->code)->first();  
        $exam_access = \App\Access::where('exam_date', $date)->first();

        if (auth()->check() && count($exam_access > 0)) 
        {
            return redirect()->route('check_exam_details');
        }
        return $next($request);
    }
}
