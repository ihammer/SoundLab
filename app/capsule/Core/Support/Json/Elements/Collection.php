<?php namespace Capsule\Core\Support\Json\Elements;

class Collection 
{
    protected $resources;

    public function __construct($type, $resources)
    {
        $this->type = $type;
        $this->resources = $resources;
    }
    
    public function getResources()
    {
        return $this->resources;
    }

    public function setResources($resources)
    {
        $this->resources = $resources;
    }

    public function toArray($full = true)
    {
        return array_map(function ($resource) use ($full) {
            return $resource->toArray($full);
        }, $this->resources);
    }
}
