<?php

namespace app\engine;

use app\engine\App;

class Storage
{
    protected $items = [];

    public function set($key, $obj)
    {
        $this->items[$key] = $obj;
    }

    public function get($key)
    {
        if (!isset($this->items[$key])) {
            $this->items[$key] = App::call()->createComponent($key);
        }
        return $this->items[$key];
    }

}