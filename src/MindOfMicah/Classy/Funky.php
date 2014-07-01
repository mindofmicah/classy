<?php
namespace MindOfMicah\Classy;

class Funky implements Contracts\Usable, Contracts\Renderable
{
    protected $include_comments = false;
    protected $lines = array();
    protected $is_static = false;
    protected $access_level = 'public';
    protected $is_chainable = false;
    protected $return_statement;
    protected $indent_level = 0;
    protected $params = array();
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return str_repeat(' ', 4*$this->indent_level) . str_replace(["\n"],["\n" . str_repeat(" ", 4* $this->indent_level)], sprintf(
            "%s%s\n{\n%s}",
            $this->include_comments ? $this->formatComments() : '',
            $this->formatMethodSignature(),
            $this->formatLines()
        ));
    }

    private function formatMethodSignature()
    {
        return sprintf(
            '%s %sfunction %s(%s)',
            $this->access_level,
            $this->is_static ? 'static ' : '',
            $this->name,
            implode(', ', $this->params)
        );
    }

    public function hasComments($include_comments = true)
    {
        $this->include_comments = !!$include_comments;
        return $this;
    }

    private function formatComments()
    {
        $spacer = ' *';
        $ret = array();
        $ret[] = '/**';
        $ret[] = ' * Description for ' . $this->name;
        $ret[] = $spacer;
        if (count($this->params)) {
            foreach($this->params as $param) {
                $ret[] = $spacer . ' ' . $param->asDocumentation();
            }
            $ret[] = $spacer;
        }
        $ret[] = ' * @return';
        $ret[] = ' */';
        return implode("\n", $ret) . "\n";
    }

    public function line($line)
    {
        $this->lines[] = $this->forceSemiColon($line);
        return $this;
    }

    private function formatLines()
    {
        $last_line = $this->getLastLine();
        if (($last_line)) {
            $this->lines[] = $last_line;
        }
        if (count($this->lines) == 0) {
            return '';
        }

        return "    " . implode("\n    ", $this->lines) . "\n";
    }

    private function getlastLine()
    {
        if ($this->is_chainable) {
            return 'return $this;';
        }
        if ($this->return_statement) {
            return 'return ' . $this->return_statement;
        }
    }

    public function isStatic()
    {
        $this->is_static = true;
        return $this;
    }

    public function isPrivate()
    {
        $this->access_level = 'private';
        return $this;
    }

    public function isProtected()
    {
        $this->access_level = 'protected';
        return $this;
    }

    public function isPublic()
    {
        $this->access_level = 'public';
        return $this;
    }

    public function returns($return_statement)
    {
        $this->return_statement = $this->forceSemiColon($return_statement);
        return $this;
    }

    private function forceSemiColon($line)
    {
        if (substr($line, 0, -1) !== ';') {
            $line.=';';
        }
        return $line;
    }

    public function isChainable()
    {
        $this->is_chainable = true;
        return $this;
    }

    public function param($new_param)
    {
        $this->params[] = Parameter::fromDefinition($new_param);
        return $this;
    }

    public function params($new_param)
    {
        $this->params = [];
        array_walk(func_get_args(), [$this, 'param']);
        return $this;
    }

    public function indent($indent = 1)
    {
        $this->indent_level+= $indent;
        return $this;
    }

    public static function make($function_name)
    {
        return new self($function_name);
    }

    public function getUseStatements()
    {
        $ret = [];
        foreach ($this->params as $param) {
            if ($temp = $param->getType()) {
                if ($temp[0] == '\\') {
                    $temp = substr($temp, 1);
                }
                $ret[$temp] = null;
            }
        }
        return array_keys($ret);
    }
}
