<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClassySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('name');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Classy');
    }

    public function it_should_render_a_basic_class()
    {
        $this->render()
            ->shouldRender('class.basic');
    }

    public function it_should_extend_a_class()
    {
        $this->willExtend('ParentClass')
            ->render()
            ->shouldRender('class.extends');
    }

    public function it_should_implement_any_number_of_interfaces()
    {
        $this->willImplement('Interface1','Interface2')
            ->willImplement('Interface3')
            ->render()
            ->shouldRender('class.interfaces');
    }

    public function getMatchers()
    {
        $expecteds = require 'expectations/classy.php'; 
        return [
            'render' => function ($subject, $key) use ($expecteds) {
                return array_key_exists($key, $expecteds) && $subject = $expecteds[$key];
            }
        ];
    }
}
