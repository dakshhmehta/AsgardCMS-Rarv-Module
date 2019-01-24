<?php

namespace spec\Modules\Rarv\Button;

use Modules\Rarv\Button\Button;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ButtonSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Button::class);
    }

    public function let()
    {
        $this->beConstructedWith('Button 1', '#button-page');
    }

    function it_has_valid_functions()
    {
        $this->setUrl('http://google.com')->getURL()->shouldBe('http://google.com');
        $this->setIcon('fa fa-users')->getIcon()->shouldBe('fa fa-users');
        $this->setLabel('Create')->getLabel()->shouldBe('Create');
        $this->setColor('success')->getColor()->shouldBeString('success');
    }

    public function it_can_accept_valid_colors()
    {
        $this->shouldThrow('\Exception')->duringSetColor('red');
    }

    public function it_can_prepare_url()
    {
        $this->setUrl('##id##/delete')->getUrl(['id' => 123])->shouldBe('123/delete');
    }

    public function it_can_set_get_attributes()
    {
        $this->setAttributes(['disabled' => true])->getAttribute('disabled')->shouldBe(true);
        $this->getAttributes()->shouldHaveCount(1);

        $this->getAttribute('size', 'foo')->shouldBe('foo');
    }

    public function it_can_get_priority()
    {
        $this->weight->shouldBe(0);
    }

    public function it_can_get_attributes_as_string()
    {
        $this->setAttributes([
            'disabled' => 'disabled', 
            'title' => 'Title'
        ])->getAttributesLine()->shouldBe('disabled="disabled" title="Title"');
    }
}
