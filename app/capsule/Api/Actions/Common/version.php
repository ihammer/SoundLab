<?php namespace Capsule\Api\Actions\Common;

use Capsule\Api\Actions\Base;

class Version extends Base {

	public function run()
	{
		$version = $this->input("version");
		if ( !$this->checkVersion($version) ) 
		{
			// 
		}
		$versonCode = $version[0] * 10000 + $version[1] * 100 + $version[2];
	}
	
	protected function checkVersion($version)
	{
		if ( empty($version)) 
		{
			return false;
		}
		return count(explode(".", $version)) === 3;
	}
}