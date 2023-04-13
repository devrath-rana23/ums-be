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

    public $name;

    public $google_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userName, $userGoogleId)
    {
        $this->name = $userName;
        $this->google_id = $userGoogleId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug($this->name . '_' . $this->google_id . '_' . 'Export Skills CSV: InProgress');
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
        Log::debug($this->name . '_' . $this->google_id . '_' . 'Export Skills CSV: Successful');
    }
}
