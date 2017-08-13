<?php namespace Capsule\Api\Actions\Advertisements;

use Capsule\Core\Advertisements\Advertisement;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\AdvertisementSerializer;

class Index extends Base {
	
	protected $advertisement;
	
	public function __construct(Advertisement $advertisement)
	{
		$this->advertisement = $advertisement;
	}
	
	public function run()
	{
		$advertisements = $this->advertisement->take(1)->orderBy('id', 'desc')->get();
		$serializer = new AdvertisementSerializer();
    $document = $this->document->setData($serializer->collection($advertisements));
    return $this->respondWithDocument($document);exit;
	}
}