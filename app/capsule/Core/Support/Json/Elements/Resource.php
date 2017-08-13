<?php namespace Capsule\Core\Support\Json\Elements;

class Resource 
{
    protected $id;

    protected $attributes = [];

    public function __construct($type, $id, $attributes = [])
    {
        $this->type = $type;
        $this->attributes = $attributes;
        $this->setId($id);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = (string) $id;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }
    
    public function getResources()
    {
        return [$this];
    }
    public function toArray($full = true)
    {
        $array = ['type' => $this->type, 'id' => $this->id];
        if ($full) {
            $array += (array) $this->attributes;
        }
        return $array;
    }
}
