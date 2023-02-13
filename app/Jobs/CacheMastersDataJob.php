<?php

namespace App\Jobs;

use App\Models\Role;
use App\Models\Skill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CacheMastersDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Redis $redis, Role $role, Skill $skill)
    {
        if ($redis::get('roles.list')) {
            $redis::del(('roles.list'));
        }
        if ($redis::get('skills.list')) {
            $redis::del(('skills.list'));
        }
        $data = $role::all();
        $redis::set('roles.list', json_encode($data));
        $data = $skill::all();
        $redis::set('skills.list', json_encode($data));
        Log::debug("CacheMastersDataJob: Succesfull {$data}");
    }
}
