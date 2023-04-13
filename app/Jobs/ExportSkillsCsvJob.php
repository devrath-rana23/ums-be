<?php

namespace App\Jobs;

use App\Models\ExportFile;
use App\Models\Skill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExportSkillsCsvJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;

    public $google_id;

    public $user_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($userName, $userGoogleId, $userId)
    {
        $this->name = $userName;
        $this->google_id = $userGoogleId;
        $this->user_id = $userId;
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
        $entityType = ExportFile::SKILLS_ENTITY;
        $entityName = ExportFile::ENTITY_NAME[$entityType];
        $filename = "{$entityName}_{$time}.csv";
        $created_by = $this->user_id;
        $filepath = config("filesystems.disks.public.url") . "/{$filename}";
        $handle = fopen(config("filesystems.disks.public.root") . "/{$filename}", 'w');
        // Add CSV headers
        fputcsv($handle, [
            'id',
            'name',
        ]);
        Skill::chunk(10, function ($skills) use ($handle) {
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

        $request = [];
        $request["entity_type"] = $entityType;
        $request["user_id"] = $created_by;
        $request["filename"] = $filename;
        $request["filepath"] = $filepath;
        $request["created_at"] = time();
        $request["updated_at"] = time();

        ExportFile::createExportFile($request);

        Log::debug($this->name . '_' . $this->google_id . '_' . 'Export Skills CSV: Successful');
    }
}
