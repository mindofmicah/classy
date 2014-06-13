<?php

namespace MindOfMicah\Classy;

class Classy
{
    protected $name;
    protected $parent_class;
    protected $interfaces = [];
    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function render()
    {
        return "class {$this->name}".($this->parent_class ?' extends '.$this->parent_class :'').$this->formatInterfaces()."\n{\n}";
    }

    public function willExtend($parent_class)
    {
        $this->parent_class = $parent_class;
        return $this;
    }

    public function willImplement($interface)
    {
        $this->interfaces = array_merge($this->interfaces, func_get_args());
        return $this;
    }

    private function formatInterfaces()
    {
        if (!count($this->interfaces)) {
            return '';
        }

        return ' implements ' . implode(', ', $this->interfaces);
    }
}
