<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use EasyWeChat;
use App\Models\User;

class UserShareQRUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user-share-image:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新用户分享二维码，批量解决 media_id 错误的问题';

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
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        $bar = $this->output->createProgressBar($users->count());
        foreach ($users as $user) {
            $user->share_img = $user->generateShareImg();
            if ($user->save()) {
                $bar->advance();
            }
        }
        $bar->finish();
    }
}
