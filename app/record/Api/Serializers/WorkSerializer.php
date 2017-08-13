<?php namespace Capsule\Api\Serializers;

use Capsule\Core\Works\Work;

class WorkSerializer extends WorkBasicSerializer {

	protected function attributes($work)
	{
		$attributes = parent::attributes($work);
		$attributes += [
			'duration'   => $work->duration,
			'tmpfile'    => $work->playurl,
			'is_private' => $work->is_private,
			'persons'    => $work->persons,
			'texts'      => $work->texts,
			'images'     => $work->images,
			'timeline'   => $work->timeline,///$work->duration,
			'LabX'       => $work->is_compshow,
		];
		return $attributes;
	}
}