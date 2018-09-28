<?php

namespace spec\Modules\Rarv\Form;

use Modules\Rarv\Form\Form;
use Modules\Rarv\Form\FormBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Response;

class FormBuilderSpec extends ObjectBehavior
{
	public function form()
	{
		return new Form('faq');
	}

    function it_is_initializable()
    {
        $this->shouldHaveType(FormBuilder::class);
    }

   	public function it_has_mode()
   	{
   		$this->getMode()->shouldBeString();
   	}

   	public function it_should_be_able_to_set_mode()
   	{
   		$this->setMode('create')->getMode()->shouldBe('create');

   		$this->setMode('edit')->getMode()->shouldBe('edit');

   		$this->shouldThrow()->duringSetMode('foo');
   	}

   	public function it_should_be_able_to_set_form()
   	{
   		$this->setForm($this->form())->getForm()->shouldBeAnInstanceOf(Form::class);
   	}

   	public function it_cant_be_touched_without_a_form()
   	{
   		$this->shouldThrow()->duringView();
   		$this->shouldThrow()->duringHandle();
   	}

   	public function it_can_have_valid_view_()
   	{
   		$this->setForm($this->form())->view()->shouldBe('faq::admin.faqs.create');
   	}

   	public function it_can_handle_form_submission()
   	{
   		$this->setForm($this->form())->handle();
   	}
}
