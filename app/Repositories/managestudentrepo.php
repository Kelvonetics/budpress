<?php

namespace App\Repositories;
use App\User;
class managestudentrepo {

public function liststudent(){
	
	$allstudent=User::where('type','=',0)->paginate(10);
	return $allstudent;
	
}

public function deletestudent($id){
	
	$deletestudent=User::find($id);
	$deletestudent->delete();
	return response()->json(['message'=>'Successfully Deleted Student']);
	
}

	
	public function statdisp(){
		//total applicant
			$total=user::where('type',0)
			->count('id');
			
			//logged in
			$totallogged=user::where('online',1)
				->where('type',0)
						->count('id');
			
			//completed
			//logged in
			$totalcomp=user::where('complete2',1)
					->where('type',0)
						->count('id');
			
			//passthru
			//logged in
			$pass=user::where('textscore','>=',30)
						->where('type',0)
						->count('id');
			
		$allstat=['total'=>$total,'totallogged'=>$totallogged,'totalcomp'=>$totalcomp,'pass'=>$pass];
		return $allstat;
	}
	
	public function resetstudent($id){
		try{
		$setcomplet=\App\User::where('id',$id)->update(['complete2'=>0,'textscore'=>0,'sync'=>0]);
		$resetcorrect=\App\studentanswer::where('user_id',$id)->delete();
		$resetstart=\DB::table('starts')->where('user_id',$id)->delete();
		$resetskip=\DB::table('skips')->where('userid',$id)->delete();

		return response()->json('success',200);

	}
	catch(\Exception $ex){
		return response()->json($ex,200);
	}
	}

	public function addapplicant($app_data){

		try{ 

		$addapplicant=\App\User::create($app_data);
		return 'Success';
		}
		catch(\Exception $ex){
			return $ex;
		}



	}
	
	
	
}