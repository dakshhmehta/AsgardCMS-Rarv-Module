<?php

namespace spec\Modules\Rarv\Form;

use Modules\Faq\Entities\Faq;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Form\Field;
use Modules\Rarv\Form\Form;
use Modules\Rarv\Form\FormBuilder;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class FormSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('faq.faqs');
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

    public function it_can_return_correct_entity()
    {
        $this->getEntity()->shouldBe('faqs');
    }

    public function it_can_set_get_field()
    {
        $questionField = new Field('question', 'normalInput');
        $this->setField($questionField)
            ->getName()->shouldBe('question');

        $this->setField('question', 'normalInput')
            ->getName()->shouldBe('question');
    }

    public function it_can_set_get_fields()
    {
        $questionField = new Field('question', 'normalInput');
        $answerField = new Field('answer', 'normalTextarea');
        $this->setFields([
            $questionField,
            $answerField
        ])->getFields()->shouldHaveCount(2);
    }

    public function it_has_boot_method()
    {
        $this->boot()->shouldReturn(true);
    }

    public function it_can_get_set_route()
    {
        $this->setRoute('/')->getRoute()->shouldBeString();
    }

    public function it_can_invalidate_form()
    {
        $this->setField('name', 'normalInput')->setRules(['required']);

        $this->validate()->shouldReturn(false);
        $this->getErrors()->shouldHaveCount(1);
    }

    public function it_can_validate_form()
    {
        $this->setField('name', 'normalInput')->setRules(['required'])->setValue('Daksh');

        $this->validate()->shouldReturn(true);
        $this->getErrors()->shouldHaveCount(0);
    }

    public function it_can_set_get_repository()
    {
        $this->setRepository('Modules\Page\Repositories\PageRepository')
            ->getRepository()->shouldBeAnInstanceOf(PageRepository::class);
    }

    public function it_can_set_the_form_model()
    {
        $this->setModel(new Faq(['question' => 'How do you do?']))->getModel()->question->shouldBe('How do you do?');
    }

    public function it_can_auto_populate_form_values_from_model()
    {
        $this->setField('question', 'normalInput')->setRules(['required']);
        $this->setModel(new Faq(['question' => 'How do you do?']));
        $this->populateValues();

        $this->getField('question')->getValue()->shouldBe('How do you do?');
    }

    public function it_has_view_path()
    {
        $this->viewPath(new FormBuilder())->shouldBeString();
    }
}
