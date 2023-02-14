<?php

namespace App\Jobs;

use App\Models\Skill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExportSkillsCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV: InProgress');
        // Open output stream
        $time = time();
        $handle = fopen("skill_{$time}.csv", 'w');
        // Add CSV headers
        fputcsv($handle, [
            'id',
            'name',
        ]);
        Skill::chunk(100, function ($skills) use ($handle) {
            foreach ($skills as $skill) {
                // Add a new row with data
                fputcsv($handle, [
                    $skill->id,
                    $skill->name,
                ]);
            }
        });
        // Close the output stream
        fclose($handle);
        Log::debug(auth()->user()->name . '_' . auth()->user()->google_id . '_' . 'Export Skills CSV: Successful');
    }
}
