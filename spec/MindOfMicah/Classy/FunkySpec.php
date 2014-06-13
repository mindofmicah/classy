<?php

namespace spec\MindOfMicah\Classy;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;

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
        $this->hasComments()
            ->render()
            ->shouldRender('empty_with_comments');
    }

    public function it_should_render_an_empty_function()
    {
        $this->render()
            ->shouldRender('default');
    }

    public function it_should_render_out_each_line_of_the_function()
    {
        $this->line('$a = "apples"')
            ->line('$a.= " and nanners"')
            ->render()
            ->shouldRender('has_lines');
    }

    public function it_should_allow_static_methods()
    {
        $this->isStatic()
            ->render()
            ->shouldRender('static');
    }
    public function it_should_allow_private_methods()
    {
        $this->isPrivate()
            ->render()
            ->shouldRender('private');
    }
    public function it_should_allow_protected_methods()
    {
        $this->isProtected()
            ->render()
            ->shouldRender('protected');
    }

    public function it_should_be_able_to_go_back_to_being_public()
    {
        $this->isPrivate()
            ->isPublic()
            ->render()
            ->shouldRender('default');
    }
    public function it_should_allow_a_syntax_sugar_for_return_statements()
    {
        $this->line("\$a = 'apples'")
            ->returns('$a')
            ->render()
            ->shouldRender('return_statement');
    }
    public function it_should_be_chainable()
    {
        $this->isChainable()
            ->render()
            ->shouldRender('chainable');
    }

    public function it_should_give_authority_to_chainable_if_it_is_used_with_returns()
    {
        $this->isChainable()
            ->returns('$a')
            ->render()
            ->shouldRender('chainable');
    }

    public function it_should_display_parameters_in_the_declaration()
    {
        $this->param('$a')
            ->param('$b')
            ->render()
            ->shouldRender('params.basic');
    }

    public function it_should_replace_existing_params_with_params_method()
    {
        $this->param('$c')
            ->params('$a', '$b')
            ->render()
            ->shouldRender('params.basic');
    }

    public function it_should_include_comments_for_parameters()
    {
        $this->params('\Models\Model $a', '$b')
            ->hasComments()
            ->render()
            ->shouldRender('params.commented');
    }

    public function getMatchers()
    {
        $expects = require 'expectations/funky.php';
        return [
            'render' => function ($subject, $key) use ($expects) {
                return array_key_exists($key, $expects) && $expects[$key] == $subject;
            }
        ];
    }
}
