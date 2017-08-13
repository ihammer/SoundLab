<?php namespace Capsule\Core\Support;

class Tagged 
{

	protected $model = "Capsule\Core\Tags\Tag";

	public function __construct($model = null)
	{
		if ( $model ) 
		{
			$this->model = $model;
		}
	}

	public function Tagging($tags, $object, $user_id, $skip_update = true)
	{
		if ( empty($user_id) ) 
		{
			return false;
		}
		$tags = Tagged::explode($tags);
		$oldTags = $object->tags()->get();
		$resolveTags = array();
		$removeTagIds = array();
		if ( !$skip_update && count($oldTags) ) 
		{
			foreach ($oldTags as $tag ) 
			{
				if ( !in_array($tag->getAttribute('name'), $tags)) 
				{
					$removeTagIds[] = $tag->getKey();
				} else 
				{
					$resolveTags[] = $tag->getAttribute('name');
				}
			}
		}

		if ( count($removeTagIds) ) 
		{
			$object->tags()->detach($removeTagIds);
			// 计数器减一
			$tagModel = $this->createModel();
			$tags     = $tagModel->whereIn('id', $removeTagIds)->get();
			foreach ($tags as $tag ) 
			{
				if ( $tag->getAttribute('count') > 0 ) 
				{
					$tag->decrement('count');
				}
			}
		}

		$newTags = array_diff($tags, $resolveTags);
		foreach ($newTags as $tag ) 
		{
			$tag = trim($tag);
			if ( $tag)  
			{
				$this->saveTag($tag, $object, $user_id);
			}
		}
	}

	public function saveTag($tag, $object, $user_id)
	{
		$object_id = $object->getKey();
		if ( !$userID = intval($user_id) || !$objectID = intval($object_id) || !$tag ) 
		{
			return false;
		}
		$tagModel = $this->createModel();
		$clearTag = $this->cleanTag($tag);
		if ( $tag = $tagModel->where('name', $clearTag)->first() )
		{
			$tag->increment('count');
			$tag->date2=date("Y-m-d H:i:s",time());
			$tag->save();
		} else
		{
			$tag = $tagModel->newInstance();
			$tag->user_id = $userID;
			$tag->name = $clearTag;
			// $tag->is_person = (int)$isPerson;
			$tag->count = 1;
			$tag->save();
		}
		$object->tags()->attach($tag->getKey());
		return true;
	}
	
	public function cleanTag($tag)
	{
		return trim($tag);
	}

	public static function explode($tags)
	{
		$tags = str_replace(array(','), ",", $tags);
		$regexp = '%(?:^|,\ *)("(?>[^"]*)(?>""[^"]* )*"|(?: [^",]*))%x';
		preg_match_all($regexp, $tags, $matches);
		$input_tags = array_unique($matches[1]);
		$tags = array();
		foreach($input_tags as $tag)
		{
			$tag = trim($tag);
			if ( $tag ) 
			{
				$tags[] = $tag;
			}
		}
		return $tags;
	}
	
	public function imploadTag($tags)
	{
		return implode(',', $tags);
	}
	public function createModel()
	{
		$class = "\\". trim($this->model,"\\");
		return new $class;
	}

	public function setModel($model)
	{
		$this->model = $model;
	}
}