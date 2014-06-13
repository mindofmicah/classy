<?php

namespace spec\MindOfMicah\Classy;

use Prophecy\Argument;

class FunkySpec extends ObjectBehavior
{
    public function let()
    {
        $this->loadExpections('expectations/funky.php');
        $this->beConstructedWith('name');
    }
    function it_is_initializable()
    {
        $this->shouldHaveType('MindOfMicah\Classy\Funky');
    }

    public function it_should_render_an_empty_function_with_comments()
    {
        $this->hasComments()->render()->shouldEqual($this->expect('empty_with_comments'));
    }

    public function it_should_render_an_empty_function()
    {
        $this->render()->shouldEqual($this->expect('default'));
    }

    public function it_should_render_out_each_line_of_the_function()
    {
        $this->line('$a = "apples"')->line('$a.= " and nanners"')->render()->shouldBe($this->expect('has_lines'));
    }

    public function it_should_allow_static_methods()
    {
        $this->isStatic()->render()->shouldEqual($this->expect('static'));
    }
    public function it_should_allow_private_methods()
    {
        $this->isPrivate()->render()->shouldEqual($this->expect('private'));
    }
    public function it_should_allow_protected_methods()
    {
        $this->isProtected()->render()->shouldEqual($this->expect('protected'));
    }

    public function it_should_be_able_to_go_back_to_being_public()
    {
        $this->isPrivate()->isPublic()->render()->shouldEqual($this->expect('default'));
    }
    public function it_should_allow_a_syntax_sugar_for_return_statements()
    {
        $this->line("\$a = 'apples'")->returns('$a')->render()->shouldEqual($this->expect('return_statement'));
    }
    public function it_should_be_chainable()
    {
        $this->isChainable()->render()->shouldEqual($this->expect('chainable'));
    }

    public function it_should_give_authority_to_chainable_if_it_is_used_with_returns()
    {
        $this->isChainable()->returns('$a')->render()->shouldEqual($this->expect('chainable'));
    }

    public function it_should_display_parameters_in_the_declaration()
    {
        $this->param('$a')->param('$b')->render()->shouldEqual($this->expect('params.basic'));
    }

    public function it_should_replace_existing_params_with_params_method()
    {
        $this->param('$c')->params('$a', '$b')->render()->shouldEqual($this->expect('params.basic'));
    }

    public function it_should_include_comments_for_parameters()
    {
        $this->params('\Models\Model $a', '$b')->hasComments()->render()->shouldEqual($this->expect('params.commented'));
    }
}
