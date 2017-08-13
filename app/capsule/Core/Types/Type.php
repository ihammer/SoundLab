<?php namespace Capsule\Core\Types;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Type extends Entity {

	use EventGenerator;

	protected $guarded = [];
	protected $table   = "types";
	
}