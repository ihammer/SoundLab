<?php namespace Capsule\Api\Actions\Messages;
use DB,Sentry;
use Capsule\Core\Messages\Message;
use Capsule\Core\Users\User;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\MessageSerializer;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Get extends Base {

	protected $message;
	
	public function __construct(Message $message)
	{
		$this->message = $message;
	}
	public function run()
	{
		//$devicetoken   = $_POST["deviceToken"];!isset($_GET['uid']) && 
		$user = Sentry::getUser();
		if ( !$user ) 
		{
			//$user=User::find($_GET['uid']);
			//throw new UserUnauthorizedException();
			throw new UserUnauthorizedException('user authorize failed');
		}
		$id   = $user->id;
		$cn=DB::table('system_messages')->where("userid","=",$id)->where('action','like','%people%')->orderBy('id', 'desc')->get();
		$page  = max(1, intval($this->input('p', 0)));
		$count = 10;
		$pages = ceil((count($cn))/$count);
		$start = ($page - 1) * $count;
		$messages = DB::table('system_messages')->where("userid","=",$id)->where('action','like','%people%')->orderBy('id', 'desc')->skip($start)->take($count)->get();//return $messages;exit;
		DB::table('system_messages')->where('userid','=',$id)->update(array('isread' => 1));
		$counts = count($messages);
		$serializer = new MessageSerializer();
		$this->document->addMeta('count', count($cn));
		$this->document->addMeta('page', $page);
		$this->document->addMeta('pages', $pages);
		$document = $this->document->setData($serializer->collection($messages));
		return $this->respondWithDocument($document);
	}
}
