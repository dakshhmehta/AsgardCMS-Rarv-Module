<?php

namespace Modules\Rarv\Tests\Unit\Form;

use Modules\Faq\Entities\Faq;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Form\Field;
use Modules\Rarv\Form\Form;
use Modules\Rarv\Form\FormBuilder;
use Tests\TestCase;

class FormTest extends TestCase
{
    public function form()
    {
        return (new Form('faq.faqs'));
    }

    public function test_is_initializable()
    {
        $this->assertInstanceOf(Form::class, $this->form());
    }

    public function test_it_can_get_module()
    {
        $this->assertNotEmpty($this->form()->getModule());
    }

    public function test_it_can_define_module()
    {
        $this->assertEquals('faq', $this->form()->setModule('faq')->getModule());
    }

    public function test_it_can_return_correct_entity()
    {
        $this->assertEquals('faqs', $this->form()->getEntity());
    }

    public function test_it_can_set_get_field()
    {
        $form = $this->form();

        $questionField = new Field('question', 'normalInput');
        $form->setField($questionField);

        // This is duplicate to previous, so override.
        $form->setField('question', 'normalInput');

        $this->assertCount(1, $form->getFields());
    }

    public function test_it_can_set_get_fields()
    {
        $questionField = new Field('question', 'normalInput');
        $answerField = new Field('answer', 'normalTextarea');
        $this->assertCount(2, $this->form()->setFields([
            $questionField,
            $answerField
        ])->getFields());
    }

    public function test_it_does_not_return_fields_if_permission_is_not_granted()
    {
        $questionField = new Field('question', 'normalInput');
        $answerField = new Field('answer', 'normalTextarea');
        $questionField->permission(false);

        $this->assertCount(1, $this->form()->setFields([
            $questionField,
            $answerField
        ])->getFields());
    }

    public function test_it_return_all_fields_even_if_permission_is_not_granted()
    {
        $questionField = new Field('question', 'normalInput');
        $answerField = new Field('answer', 'normalTextarea');
        $questionField->permission(false);

        $this->assertCount(2, $this->form()->setFields([
            $questionField,
            $answerField
        ])->getAllFields());
    }

    public function test_it_has_boot_method()
    {
        $this->assertTrue($this->form()->boot());
    }

    public function it_can_get_set_route()
    {
        $this->assertNotEmpty($this->form()->setRoute('/')->getRoute());
    }

    public function test_it_can_invalidate_form()
    {
        $form = $this->form();

        $form->setField('name', 'normalInput')->setRules(['required']);

        $this->assertFalse($form->validate());
        $this->assertCount(1, $form->getErrors());
    }

    /**
     * @depends test_it_can_invalidate_form
     */
    public function test_it_can_validate_form()
    {
        $form = $this->form();
        $form->setField('name', 'normalInput')->setRules(['required'])->setValue('Daksh');

        $this->assertTrue($form->validate());
        $this->assertCount(0, $form->getErrors());
    }

    public function test_it_can_set_get_repository()
    {
        $this->assertInstanceOf(PageRepository::class, $this->form()->setRepository('Modules\Page\Repositories\PageRepository')
            ->getRepository());
    }

    public function test_it_can_set_the_form_model()
    {
        $this->assertEquals('How do you do?', $this->form()->setModel(new Faq(['question' => 'How do you do?']))->getModel()->question);
    }

    public function test_it_can_auto_populate_form_values_from_model()
    {
        $form = $this->form();
        $form->setField('question', 'normalInput')->setRules(['required']);
        $form->setModel(new Faq(['question' => 'How do you do?']));
        $form->populateValues();

        $this->assertEquals('How do you do?', $form->getField('question')->getValue());
    }

    public function test_it_has_view_path()
    {
        $this->assertNotEmpty($this->form()->viewPath(new FormBuilder()));
    }
}
