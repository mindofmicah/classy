<?php
namespace MindOfMicah\Classy;

class Funky
{
    protected $include_comments = false;
    protected $lines = array();
    protected $is_static = false;
    protected $access_level = 'public';
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function render()
    {
        return sprintf(
            "%s%s\n{\n%s}",
            $this->include_comments ? $this->formatComments() : '',
            $this->formatMethodSignature(),
            $this->formatLines()
        );
    }

    private function formatMethodSignature()
    {
        return sprintf(
            '%s %sfunction %s()',
            $this->access_level,
            $this->is_static ? 'static ' : '',
            $this->name
        );
    }

    public function comments($include_comments = true)
    {
        $this->include_comments = !!$include_comments;
        return $this;
    }

    private function formatComments()
    {
        $ret = array();
        $ret[] = '/**';
        $ret[] = ' * Description for ' . $this->name;
        $ret[] = ' *';
        $ret[] = ' * @return';
        $ret[] = ' */';
        return implode("\n", $ret) . "\n";
    }

    public function line($line)
    {
        if (substr($line, 0, -1) !== ';') {
            $line.=';';
        }
        $this->lines[] = $line;
        return $this;
    }
    private function formatLines()
    {
        if (count($this->lines) == 0) {
            return '';
        }
        return "    " . implode("\n    ", $this->lines) . "\n";
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
        return $this->line('return ' . $return_statement);
    }
}
