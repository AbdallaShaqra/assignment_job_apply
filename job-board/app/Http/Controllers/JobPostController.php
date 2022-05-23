<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobPostController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $jobPost = JobPost::all();
        return response()->json([
            "success" => true,
            "message" => "Job Post List",
            "data" => $jobPost
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'title' => 'required',
            'desc' => 'required'
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()],422);
        }
        $jobPost = JobPost::create($input);
        return response()->json([
            "success" => true,
            "message" => "Job Post created successfully.",
            "data" => $jobPost
        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobPost = JobPost::find($id);
        if (is_null($jobPost)) {
            return response(['errors'=>'Job Post not found.']);
        }
        return response()->json([
            "success" => true,
            "message" => "Job Post retrieved successfully.",
            "data" => $jobPost
        ]);
    }

    /**
     * @param Request $request
     * @param JobPost $jobPost
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, JobPost $jobPost)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'id' => 'required',
            'title' => 'nullable',
            'desc' => 'nullable'
        ]);
        if($validator->fails()){
            return response(['errors'=>$validator->errors()->all()],422);
        }
        $data = $jobPost->where('id',$input['id'])->update($input);
        return response()->json([
            "success" => true,
            "message" => "Job Post updated successfully.",
            "data" => $data
        ]);
    }
}
