<?php

namespace spec\MindOfMicah\Classy;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FunkySpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('name');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Funky');
    }

    public function it_should_render_an_empty_function_with_comments()
    {
        $expected = <<<CODE
/**
 * Description for name
 *
 * @return
 */
public function name()
{
}
CODE;
        $this->hasComments()->render()->shouldEqual($expected);
    }
    public function it_should_render_an_empty_function()
    {
        $expected = <<<CODE
public function name()
{
}
CODE;
        #$this->render()->shouldEqual("public function name()\n{\n}");
        $this->render()->shouldEqual($expected);
    }

    public function it_should_render_out_each_line_of_the_function()
    {
        $expected = <<<CODE
public function name()
{
    \$a = "apples";
    \$a.= " and nanners";
}
CODE;
        $this->line('$a = "apples"')->line('$a.= " and nanners"')->render()->shouldBe($expected);
    }

    public function it_should_allow_static_methods()
    {
        $expected = <<<CODE
public static function name()
{
}
CODE;
        $this->isStatic()->render()->shouldEqual($expected);
    }
    public function it_should_allow_private_methods()
    {
        $expected = <<<CODE
private function name()
{
}
CODE;
        $this->isPrivate()->render()->shouldEqual($expected);
    }
    public function it_should_allow_protected_methods()
    {
        $expected = <<<CODE
protected function name()
{
}
CODE;
        $this->isProtected()->render()->shouldEqual($expected);
    }

    public function it_should_be_able_to_go_back_to_being_public()
    {
        $expected = <<<CODE
public function name()
{
}
CODE;
        $this->isPrivate()->isPublic()->render()->shouldEqual($expected);
    }
    public function it_should_allow_a_syntax_sugar_for_return_statements()
    {
        $expected = <<<CODE
public function name()
{
    \$a = 'apples';
    return \$a;
}
CODE;
        $this->line("\$a = 'apples'")->returns('$a')->render()->shouldEqual($expected);
    }
    public function it_should_be_chainable()
    {
        $expected = <<<CODE
public function name()
{
    return \$this;
}
CODE;
        $this->isChainable()->render()->shouldEqual($expected);
    }

    public function it_should_give_authority_to_chainable_if_it_is_used_with_returns()
    {
        $expected = <<<CODE
public function name()
{
    return \$this;
}
CODE;
        $this->isChainable()->returns('$a')->render()->shouldEqual($expected);
    }

    public function it_should_display_parameters_in_the_declaration()
    {
        $expected = <<<CODE
public function name(\$a, \$b)
{
}
CODE;
        $this->param('$a')->param('$b')->render()->shouldEqual($expected);;
    }

    public function it_should_replace_existing_params_with_params_method()
    {
        $expected = <<<CODE
public function name(\$b, \$s)
{
}
CODE;
        $this->param('$a')->params('$b', '$s')->render()->shouldEqual($expected);
    }

    public function it_should_include_comments_for_parameters()
    {
        $expected = <<<CODE
/**
 * Description for name
 *
 * @param \Models\Model \$a
 * @param string \$b
 *
 * @return
 */
public function name(\Models\Model \$a, \$b)
{
}
CODE;
        $this->params('\Models\Model $a', '$b')->hasComments()->render()->shouldEqual($expected);
    }
}


