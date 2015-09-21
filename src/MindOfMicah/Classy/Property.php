<?php

namespace MindOfMicah\Classy;

class Property implements Contracts\Renderable
{
    private $is_static = false;
    private $indent_level = 0;
    public function __construct($argument1, $argument2, $argument3)
    {
        $this->name = $argument1;
        $this->value = $argument2;
        $this->scope = $argument3;
    }

    public function render()
    {
        return implode(' = ', array_filter([$this->renderLeftSide(), $this->renderRightSide($this->value)])) . ';';
    }

    private function renderLeftSide()
    {
        return str_repeat(' ', $this->indent_level * 4) . implode(' ', array_filter([$this->scope, $this->is_static?'static':'', '$' . $this->name])); 
    }

    private function renderRightSide($value)
    {
        if (is_null($value)) {
            return;
        }
        if ($value === false) {
            return 'false';
        } 
        if ($value === true) {
            return 'true';
        }

        if (is_array($value)) {
            return $this->renderArrayContents($value);
        }
        return "'" . $value . "'";
    }
    
    public function isStatic()
    {
        $this->is_static = true;
        return $this;
    }

    private function isIndexedArray(array $ary)
    {
        $dummy = range(0, count($ary) - 1);
        
        return array_keys($ary) == $dummy;
    }

    private function renderArrayContents(array $ary)
    {
        $guts = $this->isIndexedArray($ary)
            ? $this->renderIndexContents($ary)
            : $this->renderAssocContents($ary);

        return implode("\n", ['[','    ' . implode(",\n    ", $guts), ']']);
    }

    private function renderIndexContents(array $ary)
    {
        return array_map(function ($e) {
            return $this->renderRightSide($e);
        }, $ary);
    }

    private function renderAssocContents(array $ary)
    {
        $lines = [];
        foreach ($ary as $key => $value) {
            $lines[] = "'{$key}' => " . $this->renderRightSide($value);
        } 
        return $lines;
    }

    public function indent($argument1)
    {
        $this->indent_level = $argument1;
        // TODO: write logic here
        return $this;
    }
}
