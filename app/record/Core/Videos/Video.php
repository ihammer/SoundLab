<?php namespace Capsule\Core\RecordsVideos;

use Sentry;
use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Video extends Entity {
	use EventGenerator;
	protected $connection = 'mysql_records';
	protected $table   = "videos";
}