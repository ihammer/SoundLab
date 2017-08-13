<?php namespace Capsule\Core\RecordsTags;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class RecordsTag extends Entity {

	use EventGenerator;
	protected $connection = 'mysql_records';
	protected $guarded = [];
	protected $table   = "tags";

}