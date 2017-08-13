<?php namespace Capsule\Api\Actions\Works;

use DB, Sentry, Response;
use Capsule\Api\Actions\Base;
use Capsule\Api\Serializers\WorkSerializer;
use Capsule\Core\Works\Commands\CreateWorkCommand;
use Capsule\Core\Works\AudioNotFoundException;
use Capsule\Core\Works\ImageRequiredException;
use Capsule\Core\Support\Exceptions\UserUnauthorizedException;

class Createnew extends Base {
	
	public function run()
	{
		if ( empty($user = Sentry::getUser()) ) 
		{
			throw new UserUnauthorizedException();
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
			'uploadId' => intval($this->input('uploadId')),
			'playUrl'  => $this->input('url'),
			'persons'  => $this->input('persons'),
			'providers'=> $this->input('providers', []),
		];
		try {
			$work = $this->execute(CreateWorkCommand::class, $input);
			$serializer = new WorkSerializer();
			$document = $this->document->setData($serializer->resource($work));		
			$work->is_verify=1;
			$work->save();
			DB::update("UPDATE users_records SET work = work＋1 WHERE record_date='".date("Y-m-d",time())."' and user_id = ".$user->getId());
			DB::update("UPDATE users SET score = score+10 WHERE id = ".$user->getId());
			return $this->respondWithDocument($document);
		} catch (AudioNotFoundException $e) {
			return Response::json(['error' => 'audio']);
		} catch(ImageRequiredException $e) {
			return Response::json(['error' => 'image']);
		}
	}
}