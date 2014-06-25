<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FileySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Filey');
        $this->shouldImplement('MindOfMicah\Classy\Contracts\Renderable');
    }

    public function it_should_render_an_empty_php_file()
    {
       $this->render()->shouldRender('file.empty'); 
    }
    public function it_should_have_a_namespace()
    {
        $this->namespaced('Apple')->shouldBe($this);
        $this->render()->shouldRender('file.hasnamespace');
    }

    public function it_should_append_content()
    {
        $this->append('apples')->shouldBe($this);
        $this->render()->shouldRender('file.hascontents');
    }

    public function it_should_render_the_contents_it_is_renderable(\MindOfMicah\Classy\Contracts\Renderable $r)
    {
        $r->render()->willReturn('stuff');
        $this->append($r)->render()->shouldRender('file.with.render');;
    }

    public function it_should_grab_use_statements_whenever_content_is_added(\MindOfMicah\Classy\Funky $e)
    {
        $e->render()->willReturn('')->shouldBeCalled();
        $e->getUseStatements()->willReturn(['Apples', 'MindOfMicah\Nachos'])->shouldBeCalled();
        $this->append($e)->shouldBe($this);;
        $this->addUseStatement('MindOfMicah\Tacos');
        $this->addUseStatement('MindOfMicah\Nachos');
        $this->render()->shouldRender('file.has.manyuses');
    }

    public function it_should_be_able_to_have_use_statements()
    {
        $this->addUseStatement('MindOfMicah\Tacos')->shouldBe($this);
        $this->addUseStatement('MindOfMicah\Nachos');
        $this->addUseStatement('MindOfMicah\Nachos');
        $this->render()->shouldRender('file.hasuses');
    }

    public function getMatchers()
    {
        $expects = require 'expectations/filey.php';
        return [
            'render' => function ($subject, $key) use ($expects) {
                return (array_key_exists($key, $expects) && $expects[$key] == $subject);
            }
        ];
    }
}

