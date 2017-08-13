<?php namespace Capsule\Api\Actions\Works;
use DB, Sentry, Response;
use Capsule\Api\Actions\Base;
use Capsule\Core\Users\User;
use Capsule\Api\Serializers\WorkSerializer;
use Capsule\Core\Works\Commands\CreateWorkCommand;
use Capsule\Core\Works\AudioNotFoundException;
use Capsule\Core\Works\ImageRequiredException;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Createtest extends Base {
		
	protected $user;

	public function __construct(User $user)
	{
		$this->user = $user;
	}
	
	
	public function run()
	{
		$mashanglu=$this->input('mashanglu',"0");
		if($mashanglu=="1"){
			$user=$this->user->findOrFail(1717);
		}elseif ( empty($user = Sentry::getUser()) ) {
			throw new UserUnauthorizedException();
			//return $mashanglu;exit;
		}
		$topic = $this->input('topicDetail',0);
		$topicName = $this->input('topicName',"");
		$topicIsPrivate = $this->input('topicIsPrivate',0);
		if($topic!=0){
			if(is_array($topic)){
				//DB::insert('insert into tags (user_id, name, topicDetail,isPrivate) values (?, ?, ?, ?)', array($user->id, $topic["topicName"], $topic["topicDetail"],$topic["topicIsPrivate"]));
				return 1;exit;
			}else{
				//$topicName = $this->input('topicName',0);
				//$topicIsPrivate = $this->input('topicIsPrivate',0);
				//DB::insert('insert into tags (user_id, name, topicDetail,isPrivate) values (?, ?, ?, ?)', array($user->id, $topicName, $topic,$topicIsPrivate));
				return 2;exit;
			}
		}elseif($topicName!=""){
			return $_POST['topicDetail'];exit;
			//return $_POST;exit;
		}else{
			return "error";exit;
		}
		$input = [
			'user'     => $user,
			'title'    => $this->input('title'),
			'waveform'    => $this->input('waveform',""),
			'tags'     => $this->input('tags'),
			'duration' => intval($this->input('duration')),
			'images'   => $this->input('images'),
			'texts'    => $this->input('texts'),
			'isPrivate'=> $this->input('isPrivate', 0),
			'isPrivate'=> $this->input('isPrivate', 0),
			'uploadId' => intval($this->input('uploadId')),
			'playUrl'  => $this->input('url'),
			'persons'  => $this->input('persons'),
			'location'=> $this->input('location', NULL),
			'locationX'=> $this->input('locationX', NULL),
			'locationY'=> $this->input('locationY', NULL),
			'price'    => $this->input('price', 0),
			'providers'=> $this->input('providers', []),
			//'topicDetail'=> $this->input('topicDetail',[]),//Topic detail Topic name
		];
		try {
			$work = $this->execute(CreateWorkCommand::class, $input);//return 1;exit;
			$serializer = new WorkSerializer();
			$document = $this->document->setData($serializer->resource($work));		
			$work->is_verify=1;
			if($mashanglu=="1"){
				$work->is_verify=0;
			}
			$work->save();
			if($mashanglu=="1"){
				return $this->respondWithDocument($document);exit;
			}
			$where=array('user_id'=>$work->user_id,'record_date'=>date("Y-m-d",time()));
			$res_record=DB::table("users_records")->where($where)->get();
			if($res_record[0]->work==0){
				$work->score=5;
				$work->save();
				DB::update("UPDATE users_records SET work = work+1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$user->id);
				DB::update("UPDATE users SET score = score+5 WHERE id = ".$user->id);
			}
			if($res_record[0]->topic==0){
				$tags=$this->input('tags');
				if(strpos($tags, "话#题")){
					DB::update("UPDATE users_records SET topic = topic+1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$user->id);
					DB::update("UPDATE users SET score = score+10 WHERE id = ".$user->id);
					$work->score=$work->score+10;
					$work->save();
				}
			}
			return $this->respondWithDocument($document);
		} catch (AudioNotFoundException $e) {
			return Response::json(['error' => 'audio']);
		} catch(ImageRequiredException $e) {
			return Response::json(['error' => 'image']);
		}
	}
}