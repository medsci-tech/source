<?php

namespace App\Http\Controllers\Home;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;
use EasyWeChat\Message\News;

class WechatController extends Controller
{
    protected $options ;
    public function __construct()
    {
        $this->options = [
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
    }

    public function index(){
        $options = $this->options;
        $app = new Application($options);
        $server = $app->server;
        $server->setMessageHandler(function($message){
            // 注意，这里的 $message 不仅仅是用户发来的消息，也可能是事件
            // 当 $message->MsgType 为 event 时为事件
            if ($message->MsgType == 'event' && $message->Event == 'subscribe') {
                return "终于等到你，感谢关注医师助手DocMate\n\n在这里，你能找到内分泌代谢性慢病最靠谱的医学知识。每周四下午6点，会准时发布我们精心准备的专题信息。\n\n点击报名<a href='http://open.mime.org.cn'>“亚太痛风联盟高尿酸血症/痛风大型公开课”</a>";
            }elseif($message->MsgType == 'text'){
                switch ($message->Content) {
                    case '甲功':
                        $new1 = new News([
                            'title'=>'这莫非就是失传已久的《甲功分析大法》？',
                            'description'=>'',
                            'url'=>'http://www.baidu.com',
                            'image'=>'https://gss0.bdstatic.com/5bVWsj_p_tVS5dKfpU_Y_D3/res/r/image/2017-09-26/352f1d243122cf52462a2e6cdcb5ed6d.png'
                        ]);
                        $new2 = new News([
                            'title'=>'为何说肠道菌群将成为下一个糖尿病治疗的新靶点？',
                            'description'=>'',
                            'url'=>'http://www.baidu.com',
                            'image'=>'https://gss0.bdstatic.com/5bVWsj_p_tVS5dKfpU_Y_D3/res/r/image/2017-09-26/352f1d243122cf52462a2e6cdcb5ed6d.png'
                        ]);
                        $new3 = new News([
                            'title'=>'医生必备的急诊手册：甲状腺危像的临床处理',
                            'description'=>'',
                            'url'=>'http://www.baidu.com',
                            'image'=>'https://gss0.bdstatic.com/5bVWsj_p_tVS5dKfpU_Y_D3/res/r/image/2017-09-26/352f1d243122cf52462a2e6cdcb5ed6d.png'
                        ]);
                        $new4 = new News([
                            'title'=>'我国2016年新版痛风指南，能否帮助医生制定更恰当的诊疗方案？',
                            'description'=>'',
                            'url'=>'http://www.baidu.com',
                            'image'=>'https://gss0.bdstatic.com/5bVWsj_p_tVS5dKfpU_Y_D3/res/r/image/2017-09-26/352f1d243122cf52462a2e6cdcb5ed6d.png'
                        ]);
                        $new5 = new News([
                            'title'=>'夜班怎么熬？这些回答都戳中了我们的心窝',
                            'description'=>'',
                            'url'=>'http://www.baidu.com',
                            'image'=>'https://gss0.bdstatic.com/5bVWsj_p_tVS5dKfpU_Y_D3/res/r/image/2017-09-26/352f1d243122cf52462a2e6cdcb5ed6d.png'
                        ]);
                        return [$new1,$new2,$new3,$new4,$new5];
                }
            }
        });
        $response = $server->serve();
        // 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
    }
    public function addMenu(){
        $app = new Application($this->options);
        $menu = $app->menu;
        $buttons = [
            [
                "name"       => "迈德干货",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "专家来了",
                        "url"  => "http://mp.weixin.qq.com/mp/homepage?__biz=MzA4NTI3MzY2NA==&hid=1&sn=a964d8f1f5eb15578c5b349a1b19b3a2&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "主任查房",
                        "url"  => "http://mp.weixin.qq.com/mp/homepage?__biz=MzA4NTI3MzY2NA==&hid=2&sn=32cfe41d360612675f6cda25a913275f&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "小明课堂",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MzA4NTI3MzY2NA==&hid=3&sn=f8d4b5fe8162ef2abe99f3c7d323734c&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "指南宝库",
                        "url" => "http://mp.weixin.qq.com/mp/homepage?__biz=MzA4NTI3MzY2NA==&hid=4&sn=f810f751182ec10b0ec966706b7c1d4d&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "直接搜索",
                        "url" => "https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzA4NTI3MzY2NA==&scene=123&from=singlemessage#wechat_redirect"
                    ],
                ],
            ],
            [
                "name" => "这里有课",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "痛风公开课",
                        "url"  => "http://open.mime.org.cn/"
                    ],[
                        "type" => "view",
                        "name" => "东方痛风论坛",
                        "url"  => "http://mp.weixin.qq.com/mp/homepage?__biz=MzA4NTI3MzY2NA==&hid=6&sn=11ac508be815f106ae3ffe7483f49289&scene=18#wechat_redirect"
                    ],[
                        "type" => "view",
                        "name" => "下载APP",
                        "url"  => "http://docmate3.mime.org.cn:82/Down.html"
                    ],[
                        "type" => "view",
                        "name" => "空中课堂",
                        "url"  => "http://airclass.mime.org.cn/"
                    ],
                ]
            ],
            [
                "name" => "关于迈德",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "迈德介绍",
                        "url"  => "http://m.dodoh5.com/JGUHX1W4/index.html#page0"
                    ],[
                        "type" => "view",
                        "name" => "加入迈德",
                        "url"  => "http://u.eqxiu.com/s/L3G2iBng"
                    ],[
                        "type" => "view",
                        "name" => "联系我们",
                        "url"  => "http://m.dodoh5.com/ZP3BT37X/index.html"
                    ]
                ]
            ],
        ];
        $menu->add($buttons);
    }
}
