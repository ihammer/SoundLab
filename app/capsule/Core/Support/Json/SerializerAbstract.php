<?php namespace Capsule\Core\Support\Json;

use Capsule\Core\Support\Json\Elements\Collection;
use Capsule\Core\Support\Json\Elements\Resource;

abstract class SerializerAbstract {

	protected $type;

	abstract protected function attributes($model);

	public function collection($data)
    {
        if (empty($data)) {
            return;
        }
        $resources = [];
        foreach ($data as $record) {
            $resources[] = $this->resource($record);
        }
        return new Collection($this->type, $resources);
    }
    
    public function resource($data)
    {
        if (empty($data)) {
            return;
        }
        if (! is_object($data)) {
            return new Resource($this->type, $data);
        } else {
            return new Resource($this->type, $data->id, $this->attributes($data));
        }
    }
}