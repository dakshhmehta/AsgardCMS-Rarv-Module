<?php

namespace Modules\Rarv\Tests\Unit\Fields;

use Modules\Faq\Entities\Faq;
use Modules\Faq\Entities\FaqHeading;
use Modules\Rarv\Form\Fields\TextField;
use Tests\TestCase;

class TextFieldTest extends TestCase {
    protected function field()
    {
        $question = Faq::first();
        $heading = FaqHeading::firstOrCreate([
            'label' => 'Test',
        ]);

        if(! $question){
            $question = Faq::create([
                'heading_id' => $heading->id,
                'en' => [
                    'question' => 'Q in english',
                    'answer' => 'A in english',
                ],
                'gu' => [
                    'question' => 'Q in gujarati',
                    'answer' => 'A in gujarati',
                ],
            ]);
        }

        return (new TextField('question', $question));
    }

    public function test_text_field_is_initializable()
    {
        $f = $this->field();

        $this->assertEquals('Q in english', $f->getValue());
    }

    public function test_text_field_can_retrive_translatable_value()
    {
        $f = $this->field()->setTranslatable();
        $this->assertEquals('Q in gujarati', $f->setLocale('gu')->getValue());
    }

    public function test_field_returns_view_based_on_translatable()
    {
        $f = $this->field();
        
        $this->assertEquals('rarv::partials.form.fields.text', $f->getView());

        $f->setTranslatable();
        $this->assertEquals('rarv::partials.form.fields.translatable.text', $f->getView());
    }
}