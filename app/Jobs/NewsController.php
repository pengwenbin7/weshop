<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Marketing;
use EasyWeChat;

class NewsController implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $Marketing;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Marketing $Marketing)
    {
        $this->Marketing = $Marketing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app = EasyWeChat::officialAccount();
        //查询分组推送用户openid
        $myuser = $app->user_tag->usersOfTag($this->Marketing->user_type, $nextOpenId = '');
        if (isset($myuser['data']['openid'])) {
            foreach ($myuser['data']['openid'] as $item) {
                $app->template_message->send([
                    'touser' => $item,
                    'template_id' => '5cyYzBA1Y0nFQ9C4YlBxVLzyppfIbhrj1dyNsVxEq1s',
                    'url' => $this->Marketing->link,
                    'data' => [
                        'first' => $this->Marketing->title,
                        'keyword1' => [
                            "value" => $this->Marketing->text_type,
                            "color" => "#2030A0",
                        ],
                        'keyword2' => $this->Marketing->result,
                        'keyword3' => [
                            "value" => time(),
                            "color" => "#2030A0",
                        ],
                        'remark' => $this->Marketing->ending,
                    ],
                ]);
            }
        }
        return;



    }
}
