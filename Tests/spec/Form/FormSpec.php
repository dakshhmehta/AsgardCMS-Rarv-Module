<?php

namespace spec\Modules\Rarv\Form;

use Modules\Rarv\Form\Form;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FormSpec extends ObjectBehavior
{
    public function let()
    {
    	$this->beConstructedWith('faq');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Form::class);
    }

    public function it_has_defined_module()
    {
    	$this->getModule()->shouldBeString();
    }

    public function it_can_define_module()
    {
    	$this->setModule('faq')->getModule()->shouldBe('faq');
    }
}
