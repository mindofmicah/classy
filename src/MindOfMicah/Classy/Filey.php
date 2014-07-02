<?php

namespace MindOfMicah\Classy;

class Filey implements Contracts\Renderable
{
    protected $namespace;
    protected $contents = '';
    protected $uses = [];
    public function render()
    {
        return sprintf('<?php%s%s%s', $this->namespace ?"\nnamespace {$this->namespace};" : '',$this->renderUseStatements(), ($this->contents != '' ?"\n{$this->contents}":''));
    }

    private function renderUseStatements()
    {
        if (!count($this->uses)) {
            return '';
        }
        $ret = '';
        foreach (array_unique($this->uses) as $use) {
            $ret.="\nuse {$use};";
        }

        if ($this->contents != '') {
            $ret.="\n";
        }
        return $ret;
    }

    public function namespaced($new_namespace)
    {
        $this->namespace = $new_namespace;
        return $this;
    }

    public function append($new_content)
    {
        if ($new_content instanceof \MindOfMicah\Classy\Contracts\Renderable) {
            $this->contents.= $new_content->render();
        } else {
            $this->contents.= (string)$new_content;
        }

        if ($new_content instanceof \MindOfMicah\Classy\Contracts\Usable) {
            $this->uses+= $new_content->getUseStatements();
        }
        return $this;
    }

    public function addUseStatement($use_statement)
    {
        $this->uses[] = $use_statement;
        return $this;
        // TODO: write logic here
    }
}
