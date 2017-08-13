<?php namespace Capsule\Core\Support\Json;

class Document {

	protected $links;
	protected $meta = array();
	protected $data;
	
	public function addLink($key, $value)
    {
        $this->links[$key] = $value;
        return $this;
    }

    public function addMeta($key, $value)
    {
        $this->meta[$key] = $value;
        return $this;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function setData($element)
    {
        $this->data = $element;
        return $this;
    }
    public function toArray()
    {
        $document = [];
        if (! empty($this->links)) {
            ksort($this->links);
            $document['links'] = $this->links;
        }
        if (! empty($this->data)) {
            $document['data'] = $this->data->toArray();
        }
        if (! empty($this->meta)) {
            $document['meta'] = $this->meta;
        }
        return $document;
    }
}