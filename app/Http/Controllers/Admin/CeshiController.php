<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use EasyWeChat;
use EasyWeChat\Kernel\Messages\Text;
use EasyWeChat\Kernel\Messages\News;
use EasyWeChat\Kernel\Messages\NewsItem;
use EasyWeChat\Kernel\Messages\Voice;
use App\Models\User;
use App\WeChat\SpreadQR;
use EasyWeChat\Kernel\Messages\Image;
use Session;

class CeshiController extends Controller
{
    public function index(Request $request)
    {

//        $app = EasyWeChat::officialAccount();
//        //群发消息
//        $tags = $app->user_tag->list();//降价消息推送    109
//        $myuser = $app->user_tag->usersOfTag(109, $nextOpenId = '');
//        if (isset($myuser['data']['openid'])) {
//            foreach ($myuser['data']['openid'] as $item) {
//                $app->template_message->send([
//                    'touser' => $item,
//                    'template_id' => 'HPp3ZBtebtk99VZYOGpLRqU7whRKqTlToI7Rq9bLP0Q',
//                    'url' => '',
//                    'data' => [
//                        'first' => '',
//                        'keyword1' => 2222,
//                        'keyword2' => '',
//                        'keyword3' => 3333,
//                        'keyword4' => '',
//                        'remark' => '',
//                    ],
//                ]);
//            }
//        }

    }
    //设置与发送模板信息
    public function index1(){
        //获取access_token
        $access_token = $this->getaccess_token();
        //这里是在模板里修改相应的变量
        $formwork = '{
           "touser":"obOoJwT4TX5uJy6bby6HQwXqRKZk",
           "template_id":"HPp3ZBtebtk99VZYOGpLRqU7whRKqTlToI7Rq9bLP0Q",
           "url":"https://api.weixin.qq.com/cgi-bin/template",            
           "data":{
                   "title": {
                       "value":"这里是自己定义的标题",
                       "color":"#173177"
                   },
                   "content":{
                       "value":"这里是自定义内容，啦啦啦",
                       "color":"#173177"
                   },
                   "time": {
                       "value":"2018/12/20",
                       "color":"#173177"
                   }
           }
       }';
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$access_token}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$formwork);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    //获取微信access_token
    public function getaccess_token(){
        if(Session::get('tocken') && Session::get('tocken_time') > time()){
            return Session::get('tocken');
        }else{
            //appid与appsecret改成你自己的
            $appid = 'wxf7f54b9a6d50abd5';
            $appsecret = 'a65372e32491aa7c920dff94050455aa';
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$appsecret}";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
            $data = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($data,true);
            Session::put('tocken',$data['access_token']);
            Session::put('tocken_time',time()+2000);
            return $data['access_token'];
        }
    }

//    public function user_id()
//    {
//        $openid = 'obOoJwWpxqeAPWmN5UNjQOgZZlJM';
//        $access_token = $this->getaccess_token();
//        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";
//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL,$url);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
//        $data = curl_exec($ch);
//        curl_close($ch);
//        $data = json_decode($data,true);
//        print_r($data);
//    }

}
