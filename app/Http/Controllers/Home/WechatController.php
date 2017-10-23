<?php

namespace App\Http\Controllers\Home;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function index(){
        $options = [
            'debug'  => true,
            'app_id' => 'wxe64196a2b2a34571',
            'secret' => '3d0085937747e85d2fcb0b1399a6e64b',
            'token'  => 'easywechat',
            // 'aes_key' => null, // 可选
            'log' => [
                'level' => 'debug',
                'file'  => storage_path('logs/easywechat.log'),
            ],
            //...
        ];
        $app = new Application($options);
        $server = $app->server;
        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event' && $message->Event == 'subscribe') {
                return "终于等到你，感谢关注医师助手DocMate\n\n在这里，你能找到内分泌代谢性慢病最靠谱的医学知识。每周四下午6点，会准时发布我们精心准备的专题信息。\n\n点击报名<a href='http://open.mime.org.cn'>“亚太痛风联盟高尿酸血症/痛风大型公开课”</a>";
            }
        });
        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
}
