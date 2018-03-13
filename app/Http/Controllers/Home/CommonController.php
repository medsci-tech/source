<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use App\Http\Model\Navs;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use Session;

class CommonController extends Controller
{
    public $doctor_id;
    public $doctor_name;
    public $doctor_mobile;
    public $protocol_check_status;

    function __construct() {
        $this->middleware(function ($request, $next) {
            if($doctor=Session::get('user')){
                $this->doctor_id =$doctor->_id;
                $this->doctor_name =$doctor->doctor_name;
                $this->doctor_mobile =$doctor->doctor_mobile;
                $this->protocol_check_status =$doctor->protocol_check_status;
            }
           return $next($request);
        });
    }

    //图片上传
    public function upload()
    {
        $file = Input::file('fileData');
        if($file -> isValid()){
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName = date('YmdHis').mt_rand(100,999).'.'.$entension;
            $path = $file -> move(base_path().'/uploads',$newName);
            $filepath = 'uploads/'.$newName;
            return $filepath;
        }
    }

    /**
     * 模拟post进行url请求
     * @param string $url
     * @param array $post_data
     */
    function request_post($url = '', $post_data = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }

        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);
        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);  // 不检查证书
        $data = curl_exec($ch);//运行curl
        //$msg  =  curl_error($ch);
        curl_close($ch);
        //dd($data);

        return $data;
    }

    function getLenovoInfo(){

        //获取联想用户信息 这里模拟post登陆获取用户session_id  uid
        $url = 'https://box.lenovo.com/v2/user/login';
        $post_data['user_slug']       = 'email:liuming@medsci-tech.com';
        $post_data['password']      = 'medsci2017';
        $res = $this->request_post($url, $post_data);
        return json_decode($res);
    }

    //key数据
//eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUxMWIyZDhjMDRhNDM5YzhjZTkxNDVmNTVlYjllMTBhNGVjMGMyM2IyMWZkZTE2Mjk2ZWY2NzZhZjQyYzdjZmM5ZWQzNmRjZDRkMTJiZDUxIn0.eyJhdWQiOiIxIiwianRpIjoiZTExYjJkOGMwNGE0MzljOGNlOTE0NWY1NWViOWUxMGE0ZWMwYzIzYjIxZmRlMTYyOTZlZjY3NmFmNDJjN2NmYzllZDM2ZGNkNGQxMmJkNTEiLCJpYXQiOjE0ODQ2NDE4NzYsIm5iZiI6MTQ4NDY0MTg3NiwiZXhwIjoxNTE2MTc3ODc2LCJzdWIiOiIxIiwic2NvcGVzIjpbImJhc2ljIl19.pRzPCtqTyVb-FJG5HsdO0IUBr_yJ2QQk0-ulxvxWHbHZUGtuPAUOYuK57-HqZvhDG2VvjxR2GgejCvDMDcYs_QoHcrRg9v_96X-4wCKo-8gx5LWpmPaE9-_8m3lGlugEC3rNXjrCXQaKCJ-yL4iriwG5qjxxSo61lzxpnTxsqIGsHp_TDAX_VcsVlvTTqiq_ET5WCqnFJQYrdwJ1Miz1aNT0evyElrSJ-gnJ91su3sq_PH995IkJ-svaY0cvk4oCqtCfZGa0ZZmlgD8KzXavKXLMvOpzaif1vsiaONSrN-z2Mc8W5mEpjL-XYmXyMX6JgVIM-zztdoRe-7G1fZRvVyw75IPqFX9_h2MSefkG-WJuCl92IipO49gnw59RCBxd1S2GsauXmG3x6aZ2a86QMmaCZ8y6GtHD_agoimmwWGdsIQBUMFBzsv1V0IH25oY1ZKoGGbJuAS0c067-SmN74ZEtw0YI_Yed1dOzoXUSIE0_4xPE0TNuAjov10EA1ktcGZbTxrmq_74oTfbLqL8xrItbrA6MFvTGDiQ33n3f2qudU0mzzZwNu7H01gNC-OsIHZaOoJFo0OGMhwc8o4fRi6SmhcIvv_E4HNudmA6iShWbVFGwed7i6csIkp_nyGHPLzlT4Qju3Oz4gZcfB7ZRC3yc6NE8ivhRdnGrO3hyKCo


    function request_post1($url = '', $post_data = array(),$header = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }

        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);
        $postUrl = $url;
        $curlPost = $post_data;
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
//        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($ch);//运行curl
        curl_close($ch);

        return $data;
    }
    //数据中心
    function registerUserCenter($data){

        $url = 'https://user.mime.org.cn/api/v0/register';
        $post_data['phone']       = $data['doctor_mobile'];
        $post_data['password']      = $data['password'];
        $post_data['name']      = $data['doctor_name'];
        $post_data['remark']="素材收集系统";
        $header = array();
        $header[] ='Accept: application/json';
        $header[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUxMWIyZDhjMDRhNDM5YzhjZTkxNDVmNTVlYjllMTBhNGVjMGMyM2IyMWZkZTE2Mjk2ZWY2NzZhZjQyYzdjZmM5ZWQzNmRjZDRkMTJiZDUxIn0.eyJhdWQiOiIxIiwianRpIjoiZTExYjJkOGMwNGE0MzljOGNlOTE0NWY1NWViOWUxMGE0ZWMwYzIzYjIxZmRlMTYyOTZlZjY3NmFmNDJjN2NmYzllZDM2ZGNkNGQxMmJkNTEiLCJpYXQiOjE0ODQ2NDE4NzYsIm5iZiI6MTQ4NDY0MTg3NiwiZXhwIjoxNTE2MTc3ODc2LCJzdWIiOiIxIiwic2NvcGVzIjpbImJhc2ljIl19.pRzPCtqTyVb-FJG5HsdO0IUBr_yJ2QQk0-ulxvxWHbHZUGtuPAUOYuK57-HqZvhDG2VvjxR2GgejCvDMDcYs_QoHcrRg9v_96X-4wCKo-8gx5LWpmPaE9-_8m3lGlugEC3rNXjrCXQaKCJ-yL4iriwG5qjxxSo61lzxpnTxsqIGsHp_TDAX_VcsVlvTTqiq_ET5WCqnFJQYrdwJ1Miz1aNT0evyElrSJ-gnJ91su3sq_PH995IkJ-svaY0cvk4oCqtCfZGa0ZZmlgD8KzXavKXLMvOpzaif1vsiaONSrN-z2Mc8W5mEpjL-XYmXyMX6JgVIM-zztdoRe-7G1fZRvVyw75IPqFX9_h2MSefkG-WJuCl92IipO49gnw59RCBxd1S2GsauXmG3x6aZ2a86QMmaCZ8y6GtHD_agoimmwWGdsIQBUMFBzsv1V0IH25oY1ZKoGGbJuAS0c067-SmN74ZEtw0YI_Yed1dOzoXUSIE0_4xPE0TNuAjov10EA1ktcGZbTxrmq_74oTfbLqL8xrItbrA6MFvTGDiQ33n3f2qudU0mzzZwNu7H01gNC-OsIHZaOoJFo0OGMhwc8o4fRi6SmhcIvv_E4HNudmA6iShWbVFGwed7i6csIkp_nyGHPLzlT4Qju3Oz4gZcfB7ZRC3yc6NE8ivhRdnGrO3hyKCo';
        $header[] ='Content-Type: application/x-www-form-urlencoded; charset=utf-8';
        $res = $this->request_post1($url, $post_data,$header);
        return json_decode($res);
    }

    function testDataCenter(){
//        get方法
        $header = array();
        $header[] = 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImUxMWIyZDhjMDRhNDM5YzhjZTkxNDVmNTVlYjllMTBhNGVjMGMyM2IyMWZkZTE2Mjk2ZWY2NzZhZjQyYzdjZmM5ZWQzNmRjZDRkMTJiZDUxIn0.eyJhdWQiOiIxIiwianRpIjoiZTExYjJkOGMwNGE0MzljOGNlOTE0NWY1NWViOWUxMGE0ZWMwYzIzYjIxZmRlMTYyOTZlZjY3NmFmNDJjN2NmYzllZDM2ZGNkNGQxMmJkNTEiLCJpYXQiOjE0ODQ2NDE4NzYsIm5iZiI6MTQ4NDY0MTg3NiwiZXhwIjoxNTE2MTc3ODc2LCJzdWIiOiIxIiwic2NvcGVzIjpbImJhc2ljIl19.pRzPCtqTyVb-FJG5HsdO0IUBr_yJ2QQk0-ulxvxWHbHZUGtuPAUOYuK57-HqZvhDG2VvjxR2GgejCvDMDcYs_QoHcrRg9v_96X-4wCKo-8gx5LWpmPaE9-_8m3lGlugEC3rNXjrCXQaKCJ-yL4iriwG5qjxxSo61lzxpnTxsqIGsHp_TDAX_VcsVlvTTqiq_ET5WCqnFJQYrdwJ1Miz1aNT0evyElrSJ-gnJ91su3sq_PH995IkJ-svaY0cvk4oCqtCfZGa0ZZmlgD8KzXavKXLMvOpzaif1vsiaONSrN-z2Mc8W5mEpjL-XYmXyMX6JgVIM-zztdoRe-7G1fZRvVyw75IPqFX9_h2MSefkG-WJuCl92IipO49gnw59RCBxd1S2GsauXmG3x6aZ2a86QMmaCZ8y6GtHD_agoimmwWGdsIQBUMFBzsv1V0IH25oY1ZKoGGbJuAS0c067-SmN74ZEtw0YI_Yed1dOzoXUSIE0_4xPE0TNuAjov10EA1ktcGZbTxrmq_74oTfbLqL8xrItbrA6MFvTGDiQ33n3f2qudU0mzzZwNu7H01gNC-OsIHZaOoJFo0OGMhwc8o4fRi6SmhcIvv_E4HNudmA6iShWbVFGwed7i6csIkp_nyGHPLzlT4Qju3Oz4gZcfB7ZRC3yc6NE8ivhRdnGrO3hyKCo';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_URL, 'https://user.mime.org.cn/api/v0/test');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }
    
}
