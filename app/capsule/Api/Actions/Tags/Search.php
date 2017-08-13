<?php namespace Capsule\Api\Actions\Tags;
use DB;
use Capsule\Core\Tags\Tag;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\TagSerializer;

class Search extends Base {

	protected $tag;

	public function __construct(Tag $tag)
	{
		$this->tag = $tag;
	}
	
	public function run()
	{
		$q = $this->input('q');
		$query = $this->tag->newQuery();
		/*switch($q)
		{
			case "记#录":
				unset($q);
				break;
			case "音#乐":
				unset($q);
				break;
			case "话#题":
				unset($q);
				break;
			case "谈#话":
				unset($q);
				break;
			case "读#书":
				unset($q);
				break;
			case "点#评":
				unset($q);
				break;
			default:
				break;
		}*/
		if ( $q )  
		{
			
			$query = $query->where('name', 'like', '%'.$q.'%');
			switch($q)
			{
				case "记录":
					$query = $query->orwhere('name', 'like', '%记#录%');
					break;
				case "音乐":
					$query = $query->orwhere('name', 'like', '%音#乐%');
					break;
				case "话题":
					$query = $query->orwhere('name', 'like', '%话#题%');
					break;
				case "谈话":
					$query = $query->orwhere('name', 'like', '%谈#话%');
					break;
				case "读书":
					$query = $query->orwhere('name', 'like', '%读#书%');
					break;
				case "点评":
					$query = $query->orwhere('name', 'like', '%点#评%');
					break;
				case "买卖":
					$query = $query->orwhere('name', 'like', '%买#卖%');
					break;
				default:
					break;
			}
			
		}
		$page  = max(1, intval($this->input('p', 0)));
		$count = $this->input('limit', 15);
		$start = ($page - 1) * $count;
		// 按最新注册的用户排序
		switch($q){
			case "#":
				$tags = $query->whereNotIn('name',array("记#录","音#乐","话#题","谈#话","读#书","点#评","买#卖"))->skip($start)->take($count)->orderBy('created_at', 'desc')->groupBy('name')->select(DB::raw('sum(count) as count,id,name'))->get();
				break;
			default :
				$tags = $query->select(DB::raw('sum(count) as count,id,name'))->skip($start)->take($count)->orderBy('created_at', 'desc')->groupBy('name')->get();
				break;
		}
		foreach($tags as $key => $val){
			switch($val->name)
			{
				case "记#录":
					$find["name"]="记录";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "音#乐":
					$find["name"]="音乐";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "话#题":
					$find["name"]="话题";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "谈#话":
					$find["name"]="谈话";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "读#书":
					$find["name"]="读书";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "点#评":
					$find["name"]="点评";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				case "买#卖":
					$find["name"]="买卖";
					$find["count"]=$val->count;
					unset($tags[$key]);
					break;
				default:
					break;
			}
		}
		if(isset($find)){
			foreach($tags as $key => $val){
				if($val->name==$find["name"]){
					$tags[$key]->count+=$find["count"];
					$tags[$key]->count=(string)$tags[$key]->count;
				}
			}
		}
		$serializer = new TagSerializer();
        $document = $this->document->setData($serializer->collection($tags));
        return $this->respondWithDocument($document);
	}
}