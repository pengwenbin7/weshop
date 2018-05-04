<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\AdminUser;

class UpdateAdminPermission implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(AdminUser $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // 清楚原有全部权限
        $ps = $this->user->permissions;
        $ps->each(function ($p) {
            $this->user->revokePermissionTo($p);
        });

        // 按照部门新建权限
        $department = $this->user->departments;
        $ps = collect();
        foreach ($department as $d) {
            $ps = $ps->merge($d->permissions);
        }
        $ps->each(function ($p) {
            $this->user->givePermissionTo($p);
        });
    }
}
