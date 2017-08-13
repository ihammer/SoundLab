<?php namespace Capsule\Core\RecordsAudios\Commands;

use Carbon\Carbon;
use Queue, DB;
use Capsule\Core\Temporaryfile;
use Capsule\Core\RecordsAudios\Audio;
use Capsule\Core\RecordsAudios\AudioNotFoundException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Illuminate\Support\Collection;

class CreateAudioCommandHandler implements CommandHandler {

	use DispatchableTrait;
	/*
	 * The work model.
	 *
	 * @var \Capsule\Core\Works\Work
	 */
	protected $audio;
	/*
	 * tmpfile model.
	 *
	 * @var \Capsule\Core\Temporaryfile
	 */
	protected $tmpfile;

	public function __construct(Audio $audio, Temporaryfile $tmpfile)
	{
		$this->audio    = $audio;
		$this->tmpfile = $tmpfile;
	}

	public function handle($command)
	{
		$user = $command->user;
		// check permission
		if ( is_null( $aud = $this->tmpfile->find($command->uploadId)) ) 
		{
			throw new AudioNotFoundException();
		}
		// 开始准备作品
		$audio = Audio::start(
			$aud,              //audio
			$command->title,     //作品标题
			$command->duration,  //作品时长
			$command->lyrics,            	 //作品打点信息
			$user                //user
		);
		$audio->save();
		$tagged = app()->make('capsule.core.recordstag');
		if ( isset($command->tags) && $command->tags ) 
		{
			$tagged->Tagging($command->tags, $audio, $user->getId());
		}
		$aud->delete();
		$this->dispatchEventsFor($audio);
		return $audio;
	}
}