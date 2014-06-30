<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use MindOfMicah\Classy\Funky;
class ClassySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('name');
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Classy');
        $this->shouldImplement('MindOfMicah\Classy\Contracts\Usable');
        $this->shouldImplement('MindOfMicah\Classy\Contracts\Renderable');
    }

    public function it_should_have_a_factory_method()
    {
        $classy = $this::make('name');
        $classy->shouldBeAnInstanceOf('MindOfMicah\Classy\Classy');
        $classy->render()->shouldRender('class.basic');
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

    public function it_should_format_functions_within_a_class(Funky $funky)
    {
        $funky->indent(1)->willReturn($funky)->shouldBeCalled();
        $funky->render()->willReturn('    function output')->shouldBeCalled();

        $this->addFunction($funky)->render()->shouldRender('class.methods');
    }

    public function it_should_gather_use_statements_from_its_methods(Funky $funky, Funky $f2)
    {
        $funky->getUseStatements()->willReturn(['FirstClass', 'SecondClass'])->shouldBeCalledTimes(1);
        $f2->getUseStatements()->willReturn(['FirstClass'])->shouldBeCalledTimes(1);
        $this->getUseStatements()->shouldHaveCount(0);
        $this->addFunction($funky);
        $this->addFunction($f2);
        $this->getUseStatements()->shouldBe([
            'FirstClass','SecondClass'
        ]);
    }

    public function it_should_gather_use_statements_from_superclasses_and_interfaces()
    {
        $this->willExtend('Namespace\BaseClass');
        $this->willImplement('Namespace\Interface1');
        $this->getUseStatements()->shouldBe([
            'Namespace\BaseClass',
            'Namespace\Interface1',
        ]);
        $this->render()->shouldRender('class.namespaced.headers');
    }


    public function getMatchers()
    {
        $expecteds = require 'expectations/classy.php'; 
        return [
            'render' => function ($subject, $key) use ($expecteds) {

                if(array_key_exists($key, $expecteds) && $subject == $expecteds[$key])
                    return true;
                 
                var_dump($expecteds[$key]);
                var_dump($subject);
                return false;
            }
        ];
    }
}
