<?php
namespace App\Http\Controllers\Home;
class SignController
{
	const APPID = "1252490301";
	const SECRET_ID = "AKIDUBoFVaLGoBuVzHgREpEh6yteEcq0YqTu";
	const SECRET_KEY = "QmLl2ayOjtwoUyH2gbR9kRPDqHD1kYVW";
	/**
	 * 生成多次有效签名函数（用于上传和下载资源，有效期内可重复对不同资源使用）
	 * @param  int $expired    过期时间,unix时间戳
	 * @param  string $bucketName 文件所在bucket
	 * @return string          签名
	 */
	public static function appSign($expired, $bucketName) {
		$appId = self::APPID;
		$secretId = self::SECRET_ID;
		$secretKey = self::SECRET_KEY;

		return self::appSignBase($appId, $secretId, $secretKey, $expired, null, $bucketName);
	}
	/**
	 * 生成单次有效签名函数（用于删除和更新指定fileId资源，使用一次即失效）
	 * @param  string $fileId     文件路径，以 /{$appId}/{$bucketName} 开头
	 * @param  string $bucketName 文件所在bucket
	 * @return string             签名
	 */
	public static function appSign_once($path, $bucketName) {
		$appId = self::APPID;
		$secretId = self::SECRET_ID;
		$secretKey = self::SECRET_KEY;
		if (preg_match('/^\//', $path) == 0) {
			$path = '/' . $path;
		}
		$fileId = '/' . $appId . '/' . $bucketName . $path;

		return self::appSignBase($appId, $secretId, $secretKey, 0, $fileId, $bucketName);
	}

	/**
	 * 签名函数（上传、下载会生成多次有效签名，删除资源会生成单次有效签名）
	 * @param  string $appId
	 * @param  string $secretId
	 * @param  string $secretKey
	 * @param  int $expired       过期时间,unix时间戳
	 * @param  string $fileId     文件路径，以 /{$appId}/{$bucketName} 开头
	 * @param  string $bucketName 文件所在bucket
	 * @return string             签名
	 */
	private static function appSignBase($appId, $secretId, $secretKey, $expired, $fileId, $bucketName) {
		$now = time();
		$rdm = rand();
		$plainText = "a=$appId&k=$secretId&e=$expired&t=$now&r=$rdm&f=$fileId&b=$bucketName";
		$bin = hash_hmac('SHA1', $plainText, $secretKey, true);
		$bin = $bin.$plainText;
		$sign = base64_encode($bin);
		return $sign;
	}
}
