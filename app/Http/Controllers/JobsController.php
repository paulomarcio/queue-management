<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Resources\CreatedJobResource;
use App\Models\Job;
use Exception;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::orderBy('id', 'asc');

        if ($request->has('status')) {
            $jobs = $jobs->where('status', $request->get('status'));
        }

        return response()->json($jobs->get());
    }

    public function create(CreateJobRequest $request)
    {
        try {
            $data = $request->validated();

            $name = $data['name'];
            $jsonData = $data['data'];

            $job = Job::create([
                'name' => $name,
                'data' => $jsonData,
                'status' => Job::PENDING
            ]);

            return response()->json(new CreatedJobResource($job));
        } catch (Exception $exception) {
            return response()->json(
                ['error' => $exception->getMessage()],
                $exception->getCode()
            );
        }
    }
}
