<?php
namespace App\Repositories;

use App\question;
use App\option;
use App\correct;
use App\result;
use App\studentanswer;
use DB;
use App\User;


class questionrepo{
	
	public function createquestion(array $question){
		$questionid=DB::table('questions')->insertGetId($question);
		
	    return $questionid;
	}
	
	public function ban($type,$id){
		try{
		$ban=User::where('id',$id)
		->update(['locked'=>$type]);
		return response()->json(1);
		}
		catch(\Exception $ex){
			return response()->json($ex);
		}
	}
	
	public function statistics(){
		
		$thirty=User::whereBetween('textscore',[0,30])
					->where('type',0)
						->count('id');
			$fourty=User::whereBetween('textscore',[31,40])
						->where('type',0)
						->count('id');
						$fifty=User::whereBetween('textscore',[41,50])
						->where('type',0)->count('id');
						$sixty=User::whereBetween('textscore',[51,60])
						->where('type',0)->count('id');
						$seventy=User::whereBetween('textscore',[61,70])
						->where('type',0)->count('id');
						$eighty=User::whereBetween('textscore',[71,80])
						->where('type',0)->count('id');
						$ninety=User::whereBetween('textscore',[81,90])
						->where('type',0)->count('id');
						$hundred=User::whereBetween('textscore',[91,100])
						->where('type',0)->count('id');
		
		$range1=["0-30%","31-40%","41-50%","51-60%","61-70%","71-80%","81-90%","91-100%"];
		
		$aggre1=['label'=>"{$range1[0]}",'value'=>$thirty];
		$aggre2=['label'=>"{$range1[1]}",'value'=>$fourty];
		$aggre3=['label'=>"{$range1[2]}",'value'=>$fifty];
		$aggre4=['label'=>"{$range1[3]}",'value'=>$sixty];
		$aggre5=['label'=>"{$range1[4]}",'value'=>$seventy];
		$aggre6=['label'=>"{$range1[5]}",'value'=>$eighty];
		$aggre7=['label'=>"{$range1[6]}",'value'=>$ninety];
		$aggre8=['label'=>"{$range1[7]}",'value'=>$hundred];
		
		$totalaggre=[$aggre1,$aggre2,$aggre3,$aggre4,$aggre5,$aggre6,$aggre7,$aggre8];
		return response()->json($totalaggre,200);
	}
	
	public function createoption(array $option){
		
		
		$option=option::create($option);
		if($option){
		  return 'success';
			
		}else{
			
			return 'failure';
		}
		
	}
	//update question function
	public function updatequestion(array $data1, array $data2,array $data3 ,$questionid){
		$updatequestion=DB::table('questions')
					->where('id',$questionid)
					->update($data1);
					
		$updateoption=DB::table('options')
					->where('question_id',$questionid)
					->update($data2);
					
		$updatecorrect=DB::table('corrects')
					->where('question_id',$questionid)
					->update($data3);
					
		if($updatequestion||$updatecorrect||$updateoption){
			
			return response()->json(['messsage'=>'You have successfully updated Question']);
			
		}
		else{
			return response()->json(['messsage'=>'You have already Updated Question']);	
		}
		
	}
	
	public function createcorrect(array $correct){
		$correct=correct::create($correct);
		if($correct){
			return 'success';
		}
		else{
			return 'failure';
			
		}
	}
	//get all questions
	public function displayquestion(){
		$questions=DB::table('questions')
		->join('options','questions.id','=','options.question_id')
		->join('corrects','questions.id','=','corrects.question_id')
		->select('questions.*','options.*','corrects.*')
		->orderBy('questions.id','desc')
		->paginate(10);
		if($questions){
			return $questions;
		}
		else{
			return response()->json(['message'=>'failure']);
		}
		
	}
	public function showsolution($userid){
		
		$solution=DB::table('questions')
		->join('options','options.question_id','=','questions.id')
		->join('applicantanswers','applicantanswers.question_id','=','questions.id')
		->where('applicantanswers.user_id','=',$userid)
		->distinct('questions.id')
		->paginate(5);
		return $solution;
		
	}
	public function countquestion(){
		
		$questioncount=question::where('daytaken',1)->count('id');
		$questioncount=46;
		return response()->json($questioncount);
	}
	public function displayquestionjson($skip)
	{		
		 
		$daytaken=date('w')+1;

		if(date('d')==20){
			$daytaken=1;
		}
		if($daytaken>=7){
			$daytaken=1;
		}

		$quescount=\DB::table('questions')->pluck('id');
		$count=count($quescount);

		   a:
	       $rand = mt_rand(1, ($count-1));

		$checkanswered=\App\studentanswer::where('question_id',$quescount[$rand])
											->where('user_id',\Auth::user()->id)
											->first();

		if(isset($checkanswered->question_id) && !empty($checkanswered->question_id))
		{
			$rand = rand(1, ($count-1));
		} 
		$questionall=DB::table('questions as q')
						->join('sections as s','q.section_id','=','s.id')
						->join('options as o','q.id','=','o.question_id')
						->join('corrects as c','q.id','=','c.question_id')
						->select('q.content','o.question_id','o.option1','o.option2','o.option3','o.option4','s.instruction','s.name as section')
						// ->where('questions.daytaken',$daytaken)
						->where('q.id',$rand)
						->get();
			if(count($questionall)==0){
				goto a;
			}
		$checkskip=\DB::table('skips')->where('userid',\Auth::user()->id)->first();
		// $time=round((session('endtime')-time())/60,2);
		 

		
		return response()->json($questionall);
	}
	
	//get question by id
	public function getquestionbyid($id){
		
		$questions=DB::table('questions')
		->join('options','questions.id','=','options.question_id')
		->join('corrects','questions.id','=','corrects.question_id')
		->select('questions.*','options.*','corrects.*')
		->where('questions.id','=',$id)
		->where('options.question_id','=',$id)
		->where('corrects.question_id','=',$id)
		->get();
		if($questions){
			return response()->json($questions);
		}
		else{
			return response()->json(['message'=>'failure']);
		}
		
	}
	
	public function deletequestion($id){
		
		$question=question::find($id);
		$question->delete();
		$option=option::where('question_id',$id);
		$option->delete();
		$correct=correct::where('question_id',$id);
		$correct->delete();
		
		return response()->json(['message'=>'successfully deleted question']);
	}
	//view all result
	public function viewresult(){
		$viewresult=user::orderBy('exam_init','desc')
		->where('type',0)
		
		->paginate(10);
		return $viewresult;
		
	}
	
		public function searchresult($name){
		$viewresult=user::where('f_name','like','%'.$name.'%')
		->where('type',0)
		->orWhere('l_name','like','%'.$name.'%')
		->orWhere('m_name','like','%'.$name.'%')
		->orWhere('ref_num','like','%'.$name.'%')
		->orderBy('exam_init','desc')
		
		->paginate(10);
		return $viewresult;
		
	}
	/** function selectcorrect($option){
		$checkcorrect=corrects::where('question_id',$questionid);
		
	} **/
	//get correct option
	public function getcorrect($questionid){
		
	 $getcorrect=correct::where('question_id',$questionid)
				->get();
			foreach($getcorrect as $option){
				
				return $option->correctoption;
			}
	
	}
	//get current users score
	public function getscore($userid){
		$myscore=user::where('id',$userid)
		->select('textscore')
		->first();
		//foreach($score as $myscore){
			
			return $myscore->textscore;
	//	}
		
	}
	/**
	public function resetanswer($userid){
		
		try{
		$delectselectedoption=studentanswer::where('user_id',$userid);
		$delectselectedoption->delete();
		
			$delectresult=result::where('user_id',$userid);
		$delectresult->delete();
		return response()->json(['message'=>'success']);
		}
		catch(\Exception $e){
			
			return response()->json(['message'=>'failure']);
		}
		
	}
	**/
	public function gettime($id){

		$checkskip=\DB::table('skips')->where('userid',$id)->first();
		if(isset($checkskip)){

		return $checkskip->tadd;
			}
			return 0;

	}

	// public function setexpired_2($type=0){

	// 	$checkskip=\DB::table('skips')->where('userid',\Auth::user()->id)->first();

	// 	if(!(session()->has('ran') || session('ran') == 1) && isset($checkskip)){
	// 		session(['ran'=>1]);
	// 		session(['starttime'=>time()]);
	// 		$newtime=session('starttime')+$checkskip->time;
	// 		session(['endtime'=>$newtime]);
	// 		return  $checkskip->time; 
	// 	}
	 
 
		 
	// 	if(!empty($checkskip) && $checkskip->time > 0){
	// 		$time=['time'=>$checkskip->time];
	// 	}
	// 	 else{
	// 	 	$time=\App\duration::first();
	// 	 } 
	 
	// 	$newtime=time()+($time['time']*60);
	// 	session(['endtime'=>$newtime]);

	//  	if($type==0){
 
	// 		return $time['time'];
	// 	}

	// 	else{

	// 		$time=round((session('endtime')-time())/60,2);
		  
	// 		if($time <=0){
	// 			$time=0;
	// 		}

	// 		return $time;
	// 	}
	 
		
	// }

	public function setexpired($type=0)
	{
		$date = date('Y-m-d');  
		$checkskip = \App\TempQuestion::where('applicant_id', 1)->where('date', $date)->orderBy('id', 'desc')->first();

		if (!$checkskip && !session()->has('starttime')) 
		{
			session(['starttime'=>time()]);
			session(['ran'=>true]);
		}

		if (!(session()->has('ran')) && $checkskip) 
		{
			session(['endtime' => session('starttime') + $checkskip->time]);
			return $checkskip->time;
		} 
		
		$time = $checkskip && $checkskip->time > 0 ? $checkskip->time : 45;	 
		session(['endtime' => time() + ( $time * 60 )]);

 		return $time;	 	
	}

	public function refreshtime()
	{
		$checkskip=\DB::table('skips')->where('userid',\Auth::user()->id)->first();

		if ($checkskip && $checkskip->added == 1) 
		{
			$newtime = time() + ( $checkskip->time * 60 );
			session(['endtime'=>$newtime]);
			$checkskip=\DB::table('skips')->where('userid',\Auth::user()->id)->update(['added'=>0]);
		} 
		return $checkskip->time;
	}
 
	public function getselected($questionid){
		$selectedoption=studentanswer::where('user_id',\Auth::user()->id)
									->where('question_id',$questionid)
									->select('selectedoption')
									->first();
									
		return response()->json($selectedoption['selectedoption'],200);
	}
	
	public function submitans($questionid,$selectedoption,$userid){
		
		$checkcorrect=questionrepo::getcorrect($questionid);
			//$getscore=questionrepo::getscore($userid);
	 
			if($checkcorrect==$selectedoption){
				
				
				return 1;
				
				}
				else {
					
				return 0;
				}
			}  
		
	public function countcomplet(){
		
		$countscore=studentanswer::where('user_id',\Auth::user()->id)
								   ->where('correct',1)
								   ->count('id');
		$countscore=round(($countscore/45)*100,2);
		$updatescore=\App\User::where('id',\Auth::user()->id)
								->update(['textscore'=>$countscore]);
								
		return $countscore;
		
		
	}
	
	public function submitanswer(array $data,$questionid,$selectedoption,$userid){
		
		 try{
				if(\Auth::user()->locked==1){
				
				return	response()->json('banned');
			
			}

		$remtime=\DB::table('skips')->where('userid',\Auth::user()->id)->first();

		if ($remtime && $remtime->time <= 0) {
			return	response()->json('expired');
		}

			//  if(time()>session('endtime')){
			// return	response()->json('expired');
			
			// } 
			$checkifanswerdalready=studentanswer::where('user_id',$data['user_id'])
									->where('question_id',$data['question_id'])
									->select('id')
									->first();

			$correct=self::submitans($questionid,$selectedoption,$userid);
			
			if($checkifanswerdalready['id']!=""){
				
			$checkifanswerdalready=studentanswer::where('user_id',$data['user_id'])
									->where('question_id',$data['question_id'])
									->update(['selectedoption'=>$data['selectedoption'],'correct'=>$correct]);
										
			}
			else{
				
				$submitanswer=studentanswer::create(['user_id'=>$data['user_id'],'question_id'=>$data['question_id'],'selectedoption'=>$data['selectedoption'],'correct'=>$correct]);
				
		
			}
			
			
		
			
			return response()->json(['message'=>'success']);
	   	}
		catch(\Exception $e){
			try{
				//already exist so do some manipulation	
			$updateanswer=studentanswer::where('question_id',$questionid)
			->update($data);
					return response()->json(['message'=>'success']);
			}
			catch(\Exception $e){
			response()->json(['message'=>'failure']);
			}
			
		
		}   
	}
	
	public function getmyresult($id){

		$gettheresult=user::where('id',$id)
		->select('textscore')
		->get();
		return response()->json($gettheresult);
		
		
	}

}







