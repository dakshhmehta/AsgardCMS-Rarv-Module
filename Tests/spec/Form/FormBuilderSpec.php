<?php

namespace spec\Modules\Rarv\Form;

use Illuminate\View\View;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Form\Form;
use Modules\Rarv\Form\FormBuilder;
use PhpSpec\Laravel\LaravelObjectBehavior;

class FormBuilderSpec extends LaravelObjectBehavior
{
    public function form()
    {
        return (new Form('faq.faq'))->setRepository(PageRepository::class);
    }

    public function it_is_initializable()
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
        $this->setForm($this->form())->view()->shouldBeAnInstanceOf(View::class);
    }

    public function it_can_handle_form_submission()
    {
        $this->setForm($this->form())->handle();
    }

    public function it_can_prepare_the_route_if_not_defined()
    {
        $this->setForm($this->form())->prepareRoute()->shouldBeString();
    }

    public function it_can_not_edit_without_form_model()
    {
        $this->setForm($this->form())->setMode('edit')->shouldThrow()->duringHandle();
        $this->setForm($this->form())->setMode('edit')->shouldThrow()->duringView();
    }

    // @todo Should populate during view render
}
