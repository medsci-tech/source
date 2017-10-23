<?php

namespace App\Http\Controllers\Home;

use EasyWeChat\Foundation\Application;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WechatController extends Controller
{
    public function index(){
        $options = [
            'debug'  => true,
            'app_id' => 'wx8e94537830df5b73',
            'secret' => '504ec19b0e522c2e14e695bdb7b30ec5',
            'token'  => 'easywechat',
            // 'aes_key' => null, // 可选
            'log' => [
                'level' => 'debug',
                'file'  => storage_path('logs/easywechat.log'),
            ],
            //...
        ];
        $app = new Application($options);
        $response = $app->server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
}
