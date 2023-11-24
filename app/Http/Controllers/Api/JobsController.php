<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        try {
            return $this->sendSuccessResponse(
                'List of jobs', 
                Response::HTTP_OK, 
                [
                    'data' => Job::select(['id', 'title', 'description'])->get()
                ]
            );
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function applyToJob(Request $request, $jobId)
    {
        try {
            $job = Job::find($jobId);

            if (!$job) return $this->sendErrorResponse('Job is not found', Response::HTTP_NOT_FOUND);

            $validateJob = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone_number' => 'required|numeric|digits_between:3,25',
                'cover_letter' => 'required',
                'resume' => 'required|mimes:pdf,doc,docx|max:2048',
            ]);

            if ($validateJob->fails()) {
                return $this->sendErrorResponse('Validation Error', Response::HTTP_BAD_REQUEST, ['errors' => $validateJob->errors()]);
            }

            $file = $request->file('resume');
            $fileName = time() . '_' . $request->phone_number;

            Storage::disk('resumes')->put($fileName, file_get_contents($file));

            JobApplication::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'cover_letter' => $request->cover_letter,
                'resume' => $fileName,
                'job_id' => $job->id,
            ]);

            return $this->sendSuccessResponse('Applied to job successfully');
        } catch (\Throwable $th) {
            return $this->sendErrorResponse($th->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
