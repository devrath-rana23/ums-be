<?php

namespace App\Jobs;

use App\Models\Role;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class CacheingRoleMasterDataJob implements ShouldQueue
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
    public function handle(Redis $redis, Role $role)
    {
        if ($redis::get('roles.list')) {
            $redis::del(('roles.list'));
        }
        $data = $role::all();
        $redis::set('roles.list', json_encode($data));
        Log::debug("CacheingRoleMasterDataJob: Succesfull {$data}");
    }
}
