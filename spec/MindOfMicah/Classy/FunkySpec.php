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
        $this->comments(true)->render()->shouldEqual($expected);
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
}


