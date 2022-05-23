<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;


class ApplicationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'job_id' => 'required',
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()],422);
        }
        $application = Application::create(['user_id'=>Auth::user()->id]);
        $jobApplication = JobApplication::create(['job_id'=>$input['job_id'],'application_id'=>$application->id]);
        return response()->json([
            "success" => true,
            "message" => "Job Application stored successfully.",
            "data" => $jobApplication
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllApplications ()
    {
        $jobApplication = JobApplication::with(['application','application.user','jobPost'])
            ->get();
        return response()->json([
            "success" => true,
            "message" => "Job Application List retrieved successfully.",
            "data" => $jobApplication
        ]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function getApplicationById (Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'app_id' => 'required',
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()],422);
        }
        Application::where('id','=',$input['app_id'])->update(['status'=>'Seen']);
        $jobApplication = JobApplication::with(['application','application.user','jobPost'])
            ->where('application_id','=',$input['app_id'])
            ->get();
        return response()->json([
            "success" => true,
            "message" => "Job Application retrieved successfully.",
            "data" => $jobApplication
        ]);

    }
}
