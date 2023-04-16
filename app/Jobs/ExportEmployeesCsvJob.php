<?php

namespace App\Jobs;

use App\Models\ExportFile;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use stdClass;

class ExportEmployeesCsvJob implements ShouldQueue
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
        Log::debug($this->name . '_' . $this->google_id . '_' . 'Export Users CSV: InProgress');
        // Open output stream
        $time = time();
        $entityType = ExportFile::USERS_ENTITY;
        $entityName = ExportFile::ENTITY_NAME[$entityType];
        $filename = "{$entityName}_{$time}.csv";
        $created_by = $this->user_id;
        $filepath = config("filesystems.disks.public.url") . "/{$filename}";
        $handle = fopen(config("filesystems.disks.public.root") . "/{$filename}", 'w');
        // Add CSV headers
        fputcsv($handle, [
            'name',
            'role',
            'birth',
            'salary',
            'marital status',
            'bonus',
        ]);
        $data = User::with('role')->with('employee')->get();
        foreach ($data as  $value) {
            $value->employee->contactInfo;
            $value->employee->skills;
        }
        foreach ($data as $user) {
            // Add a new row with data
            fputcsv($handle, [
                $user->name,
                $user->role->name,
                $user->employee->birth,
                $user->employee->martial_status,
                $user->employee->bonus,
            ]);
        }
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

        Log::debug($this->name . '_' . $this->google_id . '_' . 'Export Users CSV: Successful');
    }
}
