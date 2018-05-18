<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\AdminUser;
use Log;

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
     * 该方法存在大量冗余
     * 非高频且为队列任务，不需要考虑效率
     * @return void
     */
    public function handle()
    {
        // 清楚原有全部权限
        $ps = $this->user->permissions;
        foreach ($ps as $p) {
            $this->user->revokePermissionTo($p);
        }
        
        // 按照部门新建权限
        $departments = $this->user->departments;
        $ps = [];
        foreach ($departments as $d) {
            foreach ($d->permissions as $p) {
                $ps[] = $p->name;
            }
        }
        $ps = array_unique($ps);
        foreach ($ps as $p) {
            $this->user->givePermissionTo($p);
        }
    }
}
