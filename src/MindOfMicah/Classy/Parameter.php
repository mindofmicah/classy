<?php

namespace MindOfMicah\Classy;

class Parameter implements Contracts\Renderable
{
    protected $name;
    protected $default;
    protected $type;
    public function __construct($parameter_name)
    {
        $this->name = $parameter_name;    
    }

    public static function fromDefinition($definition)
    {
        if (preg_match('/(?:(?P<namespace>[\S]+)\s+)?(?P<name>\$[\S]+?)(?:\s*=\s*(?P<default>.+))?$/', $definition, $match)) {
            
            $parameter = new self($match['name']);
            if (!empty($match['namespace'])) {
                $parameter->setType($match['namespace']);
            }
            if (!empty($match['default'])) {
                $parameter->setDefault($match['default']);
            }
            return $parameter;

        }
        

        if (count($match) == 3) {
            // there is a
        } else {
            // there is no default value
        }
        var_dump($match);
       
return;
        $chunks = explode(' ', $definition);
        if (count($chunks) == 1) {
            return new self($chunks[0]);
        }

    
        preg_match('/([\S]+ )?(.*)/', $definition, $match);
        var_dump($chunks);

        return new self($name);
        // TODO: write logic here
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDefault()
    {
        // TODO: write logic here
        return $this->default;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($new_type)
    {
        // TODO: write logic here
        $this->type = $new_type;
        return $this;
    }

    public function setDefault($new_default)
    {
        $this->default = $new_default;
        return $this;
    }

    public function render()
    {
        return sprintf(
            '%s%s%s', 
            $this->formatType(), 
            $this->name,
            $this->default ? ' = ' . $this->default : ''
        );
    }

    private function formatType()
    {
        if (!$this->type) {
            return '';
        }

        if (preg_match('/[^\\\]+$/', $this->type, $match)) {
           return $match[0] . ' '; 
        }

        return $this->type . ' ';
    }

    public function __toString()
    {
        return $this->render();
    }

    public function asDocumentation()
    {
        return '@param ' . ($this->type?:'string') . ' '. $this->name;
    }
}
