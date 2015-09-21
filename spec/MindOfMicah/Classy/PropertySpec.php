<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PropertySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('name', 'santa', 'public');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Property');
        $this->shouldImplement('MindOfMicah\Classy\Contracts\Renderable');
    }

    public function it_can_be_indented()
    {
        $this->indent(1)->render()->shouldRender('property.indented');
    }

    public function it_should_be_rendered_as_a_formatted_property()
    {
        $this->render()->shouldRender('default.public');
    }

    public function it_should_be_able_to_be_private()
    {
        $this->beConstructedWith('name', 'santa', 'private');
        $this->render()->shouldRender('default.private');
    }

    public function it_should_be_able_to_be_protected()
    {
        $this->beConstructedWith('name', 'santa', 'protected');
        $this->render()->shouldRender('default.protected');
    }

    public function it_should_be_able_to_be_static()
    {
        $this->isStatic()->render()->shouldRender('static');
    }

    public function it_should_allow_values_to_be_null()
    {
        $this->beConstructedWith('name', null, 'public');
        $this->render()->shouldRender('nullable');
    }

    public function it_can_have_true_as_a_value()
    {
        $this->beConstructedWith('name', true, 'public');
        $this->render()->shouldRender('boolean.true');
    }
    public function it_can_have_false_as_a_value()
    {
        $this->beConstructedWith('name', false, 'public');
        $this->render()->shouldRender('boolean.false');
    }

    public function it_can_have_an_array_as_the_value()
    {
        $this->beConstructedWith('names', ['santa','rudolph'], 'public');
        $this->render()->shouldRender('arrays.indexed');
    }
    public function it_can_have_an_assoc_array_as_the_value()
    {
        $this->beConstructedWith('names', ['first' => 'santa', 'second'=>'rudolph'], 'public');
        $this->render()->shouldRender('arrays.assoc');
    }


    public function getMatchers()
    {
        $expects = require 'expectations/property.php';
        return [
            'render' => function ($subject, $key) use ($expects) {
                if (array_key_exists($key, $expects) && $expects[$key] == $subject) return true;
                var_dump($subject);
                var_dump($expects[$key]);
            }
        ];
    }

}
