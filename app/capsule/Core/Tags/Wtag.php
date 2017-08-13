<?php namespace Capsule\Core\Tags;

use Capsule\Core\Entity;
use Laracasts\Commander\Events\EventGenerator;

class Wtag extends Entity {

	use EventGenerator;

	protected $guarded = [];
	protected $table   = "works_tags";