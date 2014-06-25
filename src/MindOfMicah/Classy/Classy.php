<?php
namespace MindOfMicah\Classy;

class Classy implements Contracts\Usable, Contracts\Renderable
{
    protected $name;
    protected $parent_class;
    protected $interfaces = [];
    protected $functions = [];
    public function __construct($name)
    {
        $this->name = ucfirst($name);
    }

    public function render()
    {
        return "class {$this->name}".($this->parent_class ?' extends '.$this->parent_class :'').$this->formatInterfaces()."\n{".$this->formatFunctions()."\n}";
    }

    private function formatFunctions()
    {
        if (!count($this->functions)) {
            return '';
        }

        $ret = '';
        foreach ($this->functions as $function) {
            $ret .= $function->indent(1)->render();
        }
        return "\n" . $ret;
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

    public function addFunction(Funky $function)
    {
        $this->functions[] = $function;
        return $this;
    }

    public function make($class_name)
    {
        return new static($class_name);
    }

    public function getUseStatements()
    {
        $ret = [];
        foreach ($this->functions as $func) {
            $ret = array_merge($ret,  $func->getUseStatements());
        }
        return array_values(array_unique($ret));
    }
}
