<?php

namespace App\Console\Commands;

use App\Models\Job;
use Illuminate\Console\Command;

class ExecuteJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process the pending jobs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobs = Job::where('status', Job::PENDING)
            ->orderBy('id', 'asc')
            ->take(env('QUEUE_MAX_PACKS', 10))
            ->get();

        foreach($jobs as $job) {
            $data = collect($job->data)->map(fn ($value) => $value + $value);
            $job->data = $data;
            $job->status = Job::PROCESSED;
            $job->result = array_rand(['Lorem ipsum dolor', 'Test 123', null], 1);
            $job->save();
        }

        return 0;
    }
}
