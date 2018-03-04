<?php
/**
 * Created by PhpStorm.
 * User: junfeng
 * Date: 2018/3/3
 * Time: 22:27
 */

namespace App\Http\Controllers\Home;


use Illuminate\Http\Request;
use Qcloud\Cos\Client;
use Qcloud\Cos\Signature;

class uploadController
{
	public $client;
	public function __construct()
	{
		$this->client = new Client(
			array(
				'region' => config('tencentcloud')['region'],
				'credentials'=> array(
					'secretId'    => config('tencentcloud')['secret_id'],
					'secretKey' => config('tencentcloud')['secret_key']
				)
			)
		);
	}


	public function getAuthorization(Request $request,$method='GET', $pathname='/')
	{
		// 获取个人 API 密钥 https://console.qcloud.com/capi
		$SecretId = config('tencentcloud')['secret_id'];
		$SecretKey = config('tencentcloud')['secret_key'];


		// 整理参数
		$queryParams = array();
		$headers = array();
		$method = strtolower($method ? $method : 'get');
		$pathname = $pathname ? $pathname : '/';
		substr($pathname, 0, 1) != '/' && ($pathname = '/' . $pathname);
		// 工具方法
		function getObjectKeys($obj)
		{
			$list = array_keys($obj);
			sort($list);
			return $list;
		}
		function obj2str($obj)
		{
			$list = array();
			$keyList = getObjectKeys($obj);
			$len = count($keyList);
			for ($i = 0; $i < $len; $i++) {
				$key = $keyList[$i];
				$val = isset($obj[$key]) ? $obj[$key] : '';
				$key = strtolower($key);
				$list[] = rawurlencode($key) . '=' . rawurlencode($val);
			}
			return implode('&', $list);
		}
		// 签名有效起止时间
		$now = time() - 1;
		$expired = $now + 600; // 签名过期时刻，600 秒后
		// 要用到的 Authorization 参数列表
		$qSignAlgorithm = 'sha1';
		$qAk = $SecretId;
		$qSignTime = $now . ';' . $expired;
		$qKeyTime = $now . ';' . $expired;
		$qHeaderList = strtolower(implode(';', getObjectKeys($headers)));
		$qUrlParamList = strtolower(implode(';', getObjectKeys($queryParams)));
		// 签名算法说明文档：https://www.qcloud.com/document/product/436/7778
		// 步骤一：计算 SignKey
		$signKey = hash_hmac("sha1", $qKeyTime, $SecretKey);
		// 步骤二：构成 FormatString
		$formatString = implode("\n", array(strtolower($method), $pathname, obj2str($queryParams), obj2str($headers), ''));
		// 步骤三：计算 StringToSign
		$stringToSign = implode("\n", array('sha1', $qSignTime, sha1($formatString), ''));
		// 步骤四：计算 Signature
		$qSignature = hash_hmac('sha1', $stringToSign, $signKey);
		// 步骤五：构造 Authorization
		$authorization = implode('&', array(
			'q-sign-algorithm=' . $qSignAlgorithm,
			'q-ak=' . $qAk,
			'q-sign-time=' . $qSignTime,
			'q-key-time=' . $qKeyTime,
			'q-header-list=' . $qHeaderList,
			'q-url-param-list=' . $qUrlParamList,
			'q-signature=' . $qSignature
		));
		return $authorization;
	}



	public function upload(Request $request){
		$client = $this->client;
		try{
			$file = $request->file('file');

			$filePath = $file->getRealPath();//真实文件地址
			$originalName = $file->getClientOriginalName();
			$ext = $file->getClientOriginalExtension();//文件后缀名
			//				echo $key;
			//				dd($filePath);
			$key = date('YmdHis').$originalName;
			// 调用 UploadManager 的 putFile 方法进行文件的上传。
			$result = $client->upload(
			//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
				$bucket='source-1252490301',
				$key,
				$body=fopen($filePath,'r+')
			);

			return response()->json(['code' => 200, 'msg' => '文件上传成功','file_url'=>$key]);
		}catch (\Exception $e){
			response()->json(['code' => 500, 'msg' => '系统错误']);
		}
	}


	public function download(Request $request){
		$cosClient = $this->client;
		$key = $request->get('key');
		// 下载文件到内存
		$result = $cosClient->getObject(array(
			//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
			'Bucket' => 'source-1252490301',
			'Key' => $key));
//		header('Content-Type:'.$result['ContentType']);
//		print_r($result);die;
		header('Content-type: application/octet-stream ');
		Header ( "Accept-Ranges: bytes" );
		Header ( "Accept-Length: " . $result['ContentLength'] );
		header("Content-Disposition:attachment; filename=".substr($key,14));
//		echo fread ( $file, filesize ( $file_dir . $file_name ) );
//		fclose ( $file );
//		exit ();
		echo($result['Body']);
//		readfile($result['Body']);

		// 下载文件到本地
//		$result = $cosClient->getObject(array(
//		//bucket的命名规则为{name}-{appid} ，此处填写的存储桶名称必须为此格式
//		'Bucket' => 'source-1252490301',
//		'Key' => $key,
//		'SaveAs' => $key));
	}
}