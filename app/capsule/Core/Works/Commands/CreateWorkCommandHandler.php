<?php namespace Capsule\Core\Works\Commands;

use Carbon\Carbon;
use Queue, DB;
use Capsule\Core\Task;
use Capsule\Core\Temporaryfile;
use Capsule\Core\Works\Work;
use Capsule\Core\Works\Image;
use Capsule\Core\Works\AudioNotFoundException;
use Capsule\Core\Works\ImageRequiredException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Commander\Events\DispatchableTrait;
use Illuminate\Support\Collection;

class CreateWorkCommandHandler implements CommandHandler {

	use DispatchableTrait;
	/*
	 * The work model.
	 *
	 * @var \Capsule\Core\Works\Work
	 */
	protected $work;
	/*
	 * tmpfile model.
	 *
	 * @var \Capsule\Core\Temporaryfile
	 */
	protected $tmpfile;

	public function __construct(Work $work, Temporaryfile $tmpfile)
	{
		$this->work    = $work;
		$this->tmpfile = $tmpfile;
	}

	public function handle($command)
	{
		$user = $command->user;
		// check permission
		if ( is_null( $audio = $this->tmpfile->find($command->uploadId)) ) 
		{
			throw new AudioNotFoundException();
		}

		$json_decode = function($data) {
			if ( is_string($data) ) 
			{
				$data = json_decode($data, true);
			}
			return $data;
		};

		if ( empty($images  = array_filter(array_map($json_decode, $command->images))) ) 
		{
			throw new ImageRequiredException();
		}

		$imageCol = new Collection();
		$faild    = false;
		$i        = 0;
		foreach ($images as $id => $image ) 
		{
			$tmpfile   = null;
			$imageModel = null;
			if ( !is_array($image) OR !isset($image['uploadId'])) 
			{
				$faild = true;
				break;
			}
			if ( is_null($tmpfile = $this->tmpfile->find(intval($image['uploadId']))) )  
			{
				$faild = true;
				break;
			}
			if ( $tmpfile->type != 2)  
			{
				$faild = true;
				$break;
			}
			$order = ($i++ * 10) + 10;
			$imageModel = (new Image)->fill([
				'orderby'  => $order,
				'width'    => 0,
				'height'   => 0,
				'etag'     => $tmpfile->etag,
				'url'      => $tmpfile->url,
				'timeline' => (float) $image["timeline"]*$command->duration,//(float)(((float)$image["timeline"])/$command->duration),
				'filename' => $tmpfile->filename,
				'filesize' => $tmpfile->filesize,
				'mime'     => $tmpfile->mime,
			]);
			// valid
			if ( !$imageModel->valid() ) 
			{
				$faild = true;
				break;
			}
			$imageCol->push($imageModel);
		}
		if ( $faild ) 
		{
			throw new ImageRequiredException();
		}
		// 第一张图片作为封面
		if ( !$cover = $imageCol->first()->url ) 
		{
			$cover = '';
		}
		$persons = [];
		$texts   = [];
		if ( $command->persons ) 
		{
			$persons = array_filter(array_map($json_decode, $command->persons));
		}
		if ( $command->texts ) 
		{
			$texts   = array_filter(array_map($json_decode, $command->texts));
		}
		// 开始准备作品
		$work = Work::start(
			$audio,              //audio
			$command->title,     //作品标题
			$command->waveform,     //作品waveform
			$cover,    		     //作品封面
			$command->duration,  //作品时长
			$command->isPrivate, //作品权限
			$texts,            	 //作品打点信息
			$persons,          	 //相关用户
			$command->location,          	 //相关用户
			$command->locationX,          	 //相关用户
			$command->locationY,          	 //相关用户
			$command->price,          	 //相关用户
			$user                //user
		);
		$work->save();
		$work->images()->saveMany($imageCol->all());
		$tagged = app()->make('capsule.core.tag');
		if ( isset($command->tags) && $command->tags ) 
		{
			$tagged->Tagging($command->tags, $work, $user->getId());
		}
		// 人物标签
		// if ( !empty($persons) ) 
		// {
		// 	// $personTagArray = array_pluck($persons, 'name');
		// 	// // slice?
		// 	// if ( $persontagString = implode(',', $personTagArray)) 
		// 	// {
		// 	// 	$tagged->Tagging($persontagString, $work, 3);
		// 	// }
		// }
		//删除时候也要删除feed表，懒得做。
		DB::table('feeds')->insert([
			'user_id' => $user->getId(),
			'work_id' => $work->getId(),
			'timeline' => new Carbon,
		]);
		// clear
		$imageIds = array_pluck($images, 'uploadId');
		$this->tmpfile->whereIn('id', $imageIds)->delete();
		$audio->delete();
		$this->dispatchEventsFor($work);
		// 临时任务
		if($command->waveform==""){
			Queue::push('Capsule\Core\Task@handleFetchPeaks', array('id' => $work->getId()));
		}
		return $work;
	}
}