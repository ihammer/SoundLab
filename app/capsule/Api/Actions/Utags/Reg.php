<?php namespace Capsule\Api\Actions\Utags;
use DB;
use Capsule\Api\Actions\Base;
use Capsule\Core\Utags\Utag;
use Capsule\Api\Serializers\UtagSerializer;

class Reg extends Base {
	
	public function run()
	{
		$count=DB::table("utags")->where("isadmin","=",0)->count();
		$pages=intval(ceil($count/10));
		if(isset($_GET["p"])){
			$page = intval($_GET["p"]) < $pages ? intval($_GET["p"]) : $pages;
		}else{
			$page = 1;
		}
		$utags=DB::table("utags")->where("isadmin","=",0)->get();//return $list;exit;
		$serializer = new UtagSerializer();
    $document = $this->document->setData($serializer->collection($utags));
    $this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
    return $this->respondWithDocument($document);
	}
}
