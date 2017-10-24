<?php

namespace App\Http\Controllers\Home;

use EasyWeChat\Foundation\Application;
use App\Http\Controllers\Controller;
use EasyWeChat\Message\News;
use EasyWeChat\Message\Text;
use Illuminate\Http\Request;

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
                return "领取你的<a href='http://source.mime.org.cn/boarding/".$message->FromUserName."'>专属登机牌</a>👈\n\n点击观看“诊疗之旅”课程\n\n<a href='http://airclass.mime.org.cn'>李娟教授：高尿酸血症与痛风的临床诊断</a>\n\n<a href='http://airclass.mime.org.cn'>姜林娣教授：痛风影像学检查及解读</a>";
            }elseif($message->MsgType == 'text'){
                switch ($message->Content) {
                    case '登机牌':
                        return new Text(["content"=>"领取你的<a href='http://source.mime.org.cn/boarding/".$message->FromUserName."'>专属登机牌</a>👈\n\n点击观看“诊疗之旅”课程\n\n<a href='http://airclass.mime.org.cn'>李娟教授：高尿酸血症与痛风的临床诊断</a>\n\n<a href='http://airclass.mime.org.cn'>姜林娣教授：痛风影像学检查及解读</a>"]);break;
                    case '甲功':
                        $new1 = new News([
                            'title'=>'这莫非就是失传已久的《甲功分析大法》？',
                            'description'=>'',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3XytSVmxCN3BSRlVnL0dQaEU1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhXeXc0NGpsX2t5NWY4NUF3eng2V3VMcUJuNHczbkpWbFdZckxHbHFvS2Z5LWhCWkhRQm5Tc3Q4N1c2YW54YU41YUFfOGRnenA5LXVJb09aZ1VEZFNjcDJ3dVNfV1JTRmVCZkhTM3h6STFOQVF%2Bfg%3D%3D&chksm=046afe2f331d77390b55629d5ddd3605c870a5d494b9d82b2c83a67ea284ba3167bd9a4249b5#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_png/ZXbFIIEOcwibtPia9wgPniaU3ib3GkdOEpibvqnRt2kreVkib2icSVWhuJQU5AK2Iwkz9hRl7gQiaH6gBxc2WUEAyicRMoA/0?wx_fmt=png'
                        ]);
                        $new2 = new News([
                            'title'=>'为何说肠道菌群将成为下一个糖尿病治疗的新靶点？',
                            'description'=>'',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3X21CRVNyeDNzVFpBTXNlMmE1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhVdmpHeXlEV1J3M3dNZF8xVGt6MEdRM2d4WV9KRnJnTEY2SEdEWVpyV0pNclNLTkh0S3Y3M3RlRjlhV291Y3BXTExNcEhsVjd6T1o3WXV4bUtzM3ctUl9GX0ZGTzl4TzhKd3l6TGQtcWZkMEF%2Bfg%3D%3D&chksm=046afe2f331d773933bd1206eee4153a40dba699364f13836d8589cce41b1594e5a56259df1b#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_png/ZXbFIIEOcwibtPia9wgPniaU3ib3GkdOEpibv8MZHpyE3icuK2JOtxibBQNwhlLSSeXic4sucsibyeVZg0Osn4Jo7mbjTMg/0?wx_fmt=png'
                        ]);
                        $new3 = new News([
                            'title'=>'医生必备的急诊手册：甲状腺危像的临床处理',
                            'description'=>'',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3X2MzY2lYZElLd01WU05zdDA1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhWNk1qUzM1enRlZkZLMEw4RzlIZ1hhSWZxeFJoYURBMC1CNGUzaWxhWjNqSUFWM3VFYUhXazlNZ1ZwdThUT0hvd0gzWWxtV1VvT2k2cVpaMVlJRmZmS01zUDJrVWF0M010UlVEcXA2VnFHbFF%2Bfg%3D%3D&chksm=046afe2f331d773982c4c779a6b7e34894e87aa2e03525e38e8f9938f3be73dfb23a0ba9a8d3#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_jpg/ZXbFIIEOcwibtPia9wgPniaU3ib3GkdOEpibvRValiapBicHWCA4NFSvDFMNPSplVRqg8P7tiacZqeVib9BTDqic7ibgxXSMA/0?wx_fmt=jpeg'
                        ]);
                        $new4 = new News([
                            'title'=>'我国2016年新版痛风指南，能否帮助医生制定更恰当的诊疗方案？',
                            'description'=>'',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3X2drbS8zU0lHWWFNakluQVg1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhVTm9SNHZ4QldTR0xEVEo2bklaNlFWZElNQl9LRFlVMlZxZzFoZGpmcUVSQV9USWJZbC1HVEFTSUR3RF93aUVZZUM3eU16eVpDd0FZZXlrZVlRUWlWU0dHWElxalFZSTJ2X0k4TjRsZmJwcFF%2Bfg%3D%3D&chksm=046afe2f331d7739c45c1112c764d71136a08782823721ee470c3b61ca2ad9ff6ae266a67629#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_jpg/ZXbFIIEOcwibtPia9wgPniaU3ib3GkdOEpibvmss0s5pLibWQul74iavicY8aCYdGwicrxdciceDh9ibadGhiaeOPQ0KBFhwdw/0?wx_fmt=jpeg'
                        ]);
                        $new5 = new News([
                            'title'=>'夜班怎么熬？这些回答都戳中了我们的心窝',
                            'description'=>'',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3XzJlLzNvc0ttVlljUWpIZmM1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhWUE9mZDN2R0k0R0ZlelVLU0pzbW9JMjNyQVF4a3FFOGVuY09xcndRWlFta0JCX0htUm1yX2J0Y2x1dVNvWGZVSFBIVzVaSlF5dGo1SXMzZ2hxZ2Zta0toN1Q3d3pZbHByUW1iZFEycHlIMUF%2Bfg%3D%3D&chksm=046afe2f331d77390abc5442fa7d8873747d0f4a25e7a84f25058d71c39bf05974122ff9e64f#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_jpg/ZXbFIIEOcwibtPia9wgPniaU3ib3GkdOEpibvJzPzkLIRJlZA0vDwibNt693RTaAuFFVic3JYjoNzPr6dgPKJiaib7I63nA/0?wx_fmt=jpeg'
                        ]);
                        return [$new1,$new2,$new3,$new4,$new5];
                        break;
                    case '南京美敦力会议':
                        return new News([
                            'title'=>'【直播预告】中国胰岛素泵治疗护理管理规范专题发布会会议直播',
                            'description'=>'美敦力开启胰岛素泵师“跨界管理”新模式',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3X0ZYeUxCK3FWSW0vRFdrb1I1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhYajNiLXNIMngydDNUZ0hEUmFqV282MFkyZ0JtcFdreWxoaXJoZVF1dkZuanlKMVd5dm4zR1lQdHQ1NzRDcjRqQzNDSTVXNnZHOWh5dHREczV0MlE3MHVlY3BtN1g5aGRPS3lHemtQd2RCMWd%2Bfg%3D%3D&chksm=046af727331d7e31431b6d21b25b17daadcdab9b67cc28f28c36c65b18a9609b898cb6b0dd77#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_png/ZXbFIIEOcwicIfAYxRoKatr1J6CBFrictQoP5wN1GwDoYBHiaqUozvHTibMOYZ6EEnmjKDX0MlrYnZEI1j1RVLubhg/0?wx_fmt=png'
                        ]);
                        break;
                    case '历史':
                    case '搜索':
                    case '既往':
                    case '已发布':
                    case '历史搜索':
                        return new Text([
                            'content'=>'https://mp.weixin.qq.com/mp/profile_ext?action=home&__biz=MzA4NTI3MzY2NA==&scene=124#wechat_redirect'
                        ]);
                        break;
                    case '指南':
                        return new Text([
                            'content'=>'110本内分泌代谢指南电子版下载地址：http://pan.baidu.com/s/1i4WIENz'
                        ]);
                        break;
                    case '降尿酸':
                    case '高尿酸':
                    case '痛风':
                        return new News([
                            'title'=>'所有关于高尿酸血症与痛风的文章',
                            'description'=>'本微信公众号在高尿酸血症与痛风领域心血集成',
                            'url'=>'https://mp.weixin.qq.com/s?__biz=MzA4NTI3MzY2NA==&tempkey=OTI3X3M2K2tPQzBlbWFUT3Jwb1E1SzE0dkpqeWNZR09FWWdMdHE1NFZHVG5kRmRMc1V0N3hUZzF1Mlh4VDhVdWNwSFgtSzdJY2cyVUliczhTLWNzVDdIamxEZlFzbVFWMURSeFZqeFpCS1B4dEF0cWUyRVZJWWU2WjBCcXBobUVzUWpVTzJMbTJyTEFmdWc3OVFjVEQ4UXU0ZkF5N1pnd1NxR0pYNXV0cnd%2Bfg%3D%3D&chksm=046afb8a331d729c526bd96606a3eceb0a150de014633fb26ea7fceae35eac48cb6bde4f72f6#rd',
                            'image'=>'https://mmbiz.qlogo.cn/mmbiz_jpg/ZXbFIIEOcw9ia8icTZYLsiasPiaI2FZNV0tjGdsVNKibRa6eicWibXd0DWWpqSic04YnicXaqfz5ZxOhHwb3Hrh6397EG3A/0?wx_fmt=jpeg'
                        ]);
                        break;
                    case '空课':
                    case '空中课堂':
                    case '报名':
                        return new Text([
                            'content'=>'空中课堂，属于基层医生的内分泌代谢病网络课堂\n\n当“在岗学习”从一个奢侈品，变成了医生职业生涯的必需品\n空中课堂，更像是一所学校，陪伴你的临床成长之旅\n具有匠人精神的各位老师，为你打磨最好的课程\n热心的助教，积极的同学，带动你一起快速成长\n\n报名方式：登陆网站airclass.mime.org.cn，请务必联系诺和诺德代表协助报名\n\n报名成功后，你可直接在上面的网站学习，或者接听语音电话\n\n详情请关注官方微信号“空中课堂云课堂”'
                        ]);
                        break;
                    case '016':
                        return new Text([
                            'content'=>'甲状腺结节与甲状腺癌共识与指南下载链接：http://pan.baidu.com/s/1qX9XLaW'
                        ]);
                        break;
                    case '015':
                        return new Text([
                            'content'=>'《2017 ATA指南：妊娠期间和产后甲状腺疾病的诊断和管理》PDF下载地址：http://pan.baidu.com/s/1cgTVp8'
                        ]);
                        break;
                    case '014':
                        return new Text([
                            'content'=>'小明课堂：妊娠期和产后甲状腺炎疾病的诊治指南推荐要点（2017 ATA）PPT下载地址：http://pan.baidu.com/s/1jINXaGA'
                        ]);
                        break;
                    case '013':
                        return new Text([
                            'content'=>'欢迎下载新鲜出炉的共识哦：2017年版《中国住院患者血糖管理专家共识》百度云下载链接：http://pan.baidu.com/s/1bI6VN4'
                        ]);
                        break;
                    case '012':
                        return new Text([
                            'content'=>'《糖尿病微循环障碍临床用药专家共识（征求意见稿）》，下载链接：http://pan.baidu.com/s/1eR2jdYU'
                        ]);
                        break;
                    case '011':
                        return new Text([
                            'content'=>'欢迎下载小明课堂PPT-《糖尿病微循环障碍的临床用药》，下载链接：http://pan.baidu.com/s/1slD8mx3'
                        ]);
                        break;
                    case '010':
                        return new Text([
                            'content'=>'JAMA-Association Between Diabetes and Cause-Specific Mortalityin Rural and Urban Areas of China原文下载链接：http://pan.baidu.com/s/1o8rZyjC'
                        ]);
                        break;
                    case '009':
                        return new Text([
                            'content'=>'内分泌代谢病临床指南与共识-更新至2017.1.16，百度云下载链接：http://pan.baidu.com/s/1hsv9uhm'
                        ]);
                        break;
                    case '008':
                        return new Text([
                            'content'=>'欢迎下载小明课堂原创PPT《2017年ADA-糖尿病神经病变的诊治要点》，下载链接：http://pan.baidu.com/s/1boXwYa7'
                        ]);
                        break;
                    case '007':
                        return new Text([
                            'content'=>'欢迎下载小明课堂原创PPT《低钠血症的诊治》，百度云下载链接：http://pan.baidu.com/s/1c2mnGGS'
                        ]);
                        break;
                    case '006':
                        return new Text([
                            'content'=>'欢迎下载小明课堂原创PPT《高血糖高渗综合征的急症处治》，百度云链接：http://pan.baidu.com/s/1eRKyViM'
                        ]);
                        break;
                    case '005':
                        return new Text([
                            'content'=>'《库欣综合征专家共识（2011年）》百度云下载链接：http://pan.baidu.com/s/1boLkZcN'
                        ]);
                        break;
                    case '004':
                        return new Text([
                            'content'=>'《甲减危象原文百度云下载链接：http://pan.baidu.com/s/1o7CbaqA'
                        ]);
                        break;
                    case '003':
                        return new Text([
                            'content'=>'《欢迎下载小明课堂原创PPT，百度云的下载链接：http://pan.baidu.com/s/1i5C1hkh'
                        ]);
                        break;
                    case '002':
                        return new Text([
                            'content'=>'《指南/共识下载链接：http://pan.baidu.com/s/1o8HG8QI'
                        ]);
                        break;
                    case '千院':
                        return new Text([
                            'content'=>'您好！我是迈德医师小助手，感谢关注。项目免费热线：400-864-8883。\n千院名医”配送TCL电视活动明细如下：\n1.您会收到电视机，U盘，三联单各一份（其中三联单一份您自己保存，一份给院方保存，另一份请邮寄给我们）详见微信菜单产品服务-->千院电视项目-->项目指南。\n2.签收电视后5个工作日内拨打400-912-3456预约TCL安装人员，并监督调试好视频内容，视频的播放必须配合U盘使用，将循环播放健康教育内容。\n3.请将安装好电视拍照，将照片直接回复本微信公众号。\n4.后续会有配合科教电视进行的一系列患教活动，敬请关注，谢谢！'
                        ]);
                        break;
                }
            }
        });
        return $server->serve();
        // 将响应输出
        //$response->send(); // Laravel 里请使用：return $response;
    }
    public function addMenu(){
        $app = new Application($this->options);
        $menu = $app->menu;
        $buttons = [
            [
                "name"       => "迈德干货1",
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
                "name" => "这里有课1",
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
                "name" => "关于迈德1",
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

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function boarding(Request $request)
    {
        $app = new Application($this->options);
        $user = $app->user->get($request->openid);
        return view('wechat.boarding',['user'=>$user]);

    }
}
