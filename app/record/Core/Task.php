<?php namespace Capsule\Core;

use Capsule\Core\Works\Work;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class Task {

	// event

	protected $work;

	protected $files;
	
	public function __construct(Work $work, Filesystem $files )
	{
		$this->work  = $work;
		$this->files = $files;
	}
	// 设计不合理，临时任务，读取音频波形数据
	public function handleFetchPeaks($job, $data)
	{
		if ( is_null($work = $this->work->find($data['id'])) ) 
		{
			return false;
		}
		if ( empty($url = $work->playurl) ) 
		{
			return false;
		}
		// check url
		// private url
		$tmpname = tempnam("/tmp", substr(md5(time()), 0, 10));
		$outputJson = $tmpname."_peaks.json";
		// download
		if ( !$this->downloadFile($url , $tmpname) ) 
		{
			$this->files->delete($tmpname);
			$job->release();
			return false;
		}
		// $process = $this->getProcess()
		$command = "waveform --wjs-width 800 --wjs-precision 2 --wjs-plain --waveformjs {$outputJson} $tmpname";
		$process = new Process($command);
		$process->setTimeout(3600);
		$process->run();
		if ( !$process->isSuccessful() ) 
		{
			$this->files->delete($tmpname);
			$this->files->delete($outputJson);
			$job->release();
			return false;
		}
		$QINIU_ACCESS_KEY = "uoChfHas3vR_XMm1Pq4A3CIVPTKhU8xi0FIavefZ";
		$QINIU_SECRET_KEY = "P3VhSYvE-osUBoi5QvkOpF-nLXdducAFp6RLmd3B";
		$auth = new Auth($QINIU_ACCESS_KEY, $QINIU_SECRET_KEY);
		$key = sprintf("ID:%s|ETAG:%s", $work->getId(), $work->etag);
		$keyHash = sprintf("%s.json",$this->base64_urlSafeEncode(substr(sha1($key), 0, 10)));
		$opts = array();
		$token = $auth->uploadToken('test', null, 3600, $opts);
		$uploadMgr = New UploadManager();
		$data = array_map(function($v) {
			return intval($v * 100);
		},json_decode($this->files->get($outputJson)));
		$data = json_encode(array('peaks' => $data));
		list($ret, $err) = $uploadMgr->put($token, $keyHash, $data);
		if ( $err ) 
		{
			$this->files->delete($tmpname);
			$this->files->delete($outputJson);
			$job->release();
			return false;
		}
		$work->waveform = $keyHash;
		$work->save();
		$this->files->delete($tmpname);
		$this->files->delete($outputJson);
		$job->delete();
	}

	public function handleShareQueue($job, $data)
	{
		// 
	}
	// @TODO utils
	protected function downloadFile($url, $path)
	{
		$result = null;
		if (ini_get('allow_url_fopen')) 
		{
            $result = file_get_contents($url);
        } else {
        	$ch = curl_init();
			$timeout = 120;
			curl_setopt($ch,CURLOPT_URL,$url);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
			$content = curl_exec($ch);
			curl_close($ch);
        }
		$size = strlen($result);
		if ( !$size ) 
		{
			return false;
		}
		$fp = fopen($path, 'w+');
		fwrite($fp, $result);
		fclose($fp);
		unset($result, $url);
		return true;
	}
	
	protected function base64_urlSafeEncode($data)
    {
        $find = array('+', '/');
        $replace = array('-', '_');
        return str_replace($find, $replace, base64_encode($data));
    }

    protected function base64_urlSafeDecode($str)
    {
        $find = array('-', '_');
        $replace = array('+', '/');
        return base64_decode(str_replace($find, $replace, $str));
    }
}