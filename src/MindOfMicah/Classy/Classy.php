<?php
namespace MindOfMicah\Classy;

class Classy implements Contracts\Usable, Contracts\Renderable
{
    protected $name;
    protected $parent_class;
    protected $interfaces = [];
    protected $functions = [];
    protected $use_statements = [];

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
        $true_class = $this->grabTrueClassName($parent_class);
        if ($true_class != $parent_class) {
            if ($parent_class[0] == '\\') {
                $parent_class = substr($parent_class, 1);
            }
            $this->use_statements[] = $parent_class;
            $parent_class = $true_class;
        }

        $this->parent_class = $parent_class;
        return $this;
    }

    private function grabTrueClassName($class)
    {
        $chunks = explode('\\', $class);
        return end($chunks);
    }

    public function willImplement($interface)
    {
        foreach (func_get_args() as $interface) {
            $true_class = $this->grabTrueClassName($interface);
            if ($true_class != $interface) {
                if ($interface[0] == '\\') {
                    $interface = substr($interface, 1);
                }
                $this->use_statements[] = $interface;
                $interface = $true_class;
            }
            $this->interfaces[] = $interface;
        }
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

    public static function make($class_name)
    {
        return new static($class_name);
    }

    public function getUseStatements()
    {
        $ret = $this->use_statements;
        foreach ($this->functions as $func) {
            $ret = array_merge($ret,  $func->getUseStatements());
        }
        return array_values(array_unique($ret));
    }
}
