<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ParameterSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('$t');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Parameter');
        $this->shouldImplement('MindOfMicah\Classy\Contracts\Renderable');
    }

    public function it_should_create_an_instance_from_a_string_of_just_the_name()
    {
        $param = $this::fromDefinition('$param');
        $param->shouldHaveType('MindOfMicah\Classy\Parameter');
        $param->getName()->shouldBe('$param');
        $param->getDefault()->shouldBe(null);
        $param->getType()->shouldBe(null);
    }

    public function it_should_create_an_instance_from_a_string_of_a_typecasted_param()
    {
        $param = $this::fromDefinition('Apples\Tacos $param');
        $param->shouldHaveType('MindOfMicah\Classy\Parameter');
        $param->getName()->shouldBe('$param');
        $param->getDefault()->shouldBe(null);
        $param->getType()->shouldBe('Apples\Tacos');
    }

    public function it_should_create_an_instance_from_a_string_with_a_default_value()
    {
         $param = $this::fromDefinition('$param = array()');
         $param->shouldHaveType('MindOfMicah\Classy\Parameter');
         $param->getName()->shouldBe('$param');
         $param->getDefault()->shouldBe('array()');
         $param->getType()->shouldBe(null);
    }
    public function it_should_create_an_instance_from_a_string_with_everything()
    {
         $param = $this::fromDefinition('Apples\Tacos $param = array()');
         $param->shouldHaveType('MindOfMicah\Classy\Parameter');
         $param->getName()->shouldBe('$param');
         $param->getDefault()->shouldBe('array()');
         $param->getType()->shouldBe('Apples\Tacos');
    }

    public function it_should_allow_manipulating_type()
    {
        $this->getType()->shouldBe(null);
        $this->setType('taaa')->shouldBe($this);
        $this->getType()->shouldBe('taaa');
    }
    public function it_should_allow_manipulating_default_value()
    {
        $this->getDefault()->shouldBe(null);
        $this->setDefault('taaa')->shouldBe($this);
        $this->getDefault()->shouldBe('taaa');
    }

    public function it_should_render_down_to_valid_php()
    {
        $this->render()->shouldBe('$t');
        $this->setDefault('array()')->render()->shouldBe('$t = array()');
        $this->setType('Apples')->render()->shouldBe('Apples $t = array()');
    }

    public function it_should_automagically_flatten_when_used_as_a_string()
    {
        $example =  new \MindOfMicah\Classy\Parameter('$t');
        $this->render()->shouldBe((string)$example);
    }
}
