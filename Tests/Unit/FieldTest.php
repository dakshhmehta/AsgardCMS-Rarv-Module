<?php

namespace Modules\Rarv\Tests\Unit;

use Illuminate\Support\HtmlString;
use Modules\Core\Tests\BaseTestCase;
use Modules\Rarv\Form\Field;

class FieldTest extends BaseTestCase {
    protected function field():Field
    {
        return (new Field('name', 'textGroup'));
    }

    public function test_it_is_initializable()
    {
        $this->assertInstanceOf(Field::class, $this->field());
    }

    public function test_it_can_have_name()
    {
        $this->assertEquals('name', $this->field()->setName('name')->getName());
    }

    public function test_it_can_have_type()
    {
        $this->assertEquals('normalInput', $this->field()->setType('normalInput')->getType());
    }

    // @todo Fix this.
    // public function test_it_can_be_rendered()
    // {
    //     $this->assertInstanceOf(HtmlString::class, $this->field()->render());
    // }

    public function it_can_set_get_rules()
    {
        $this->assertCount(1, $this->field()->setRules(['required'])->getRules());
    }

    public function test_it_can_validate_the_field()
    {
        $this->assertFalse($this->field()->setValue(null)->setRules(['required'])->validate());
        $this->assertTrue($this->field()->setValue('dax')->setRules(['required'])->validate());
    }

    public function test_it_can_set_get_translatable_value()
    {
        $field = $this->field()->setTranslatable();
        $field->setValue([
            'en' => 'EN',
            'gu' => 'GU',
        ]);

        $this->assertEquals('EN', $field->getValue());

        app()->setLocale('gu');
        $this->assertEquals('GU', $field->getValue());

        $this->assertEquals('EN', $field->setLocale('en')->getValue());
    }

    public function test_it_can_set_get_label()
    {
        $this->assertEquals('Question: ', $this->field()->setLabel('Question: ')->getLabel());
    }

    public function test_it_can_get_set_columns()
    {
        $this->assertEquals(1, $this->field()->setColumn(1)->getColumn());
    }

    public function test_it_can_not_set_column_invalid()
    {
        $this->expectException(\Exception::class);
        $this->field()->setColumn('dax');
        // $this->shouldThrow()->duringSetColumn(13);
        // $this->shouldThrow()->duringSetColumn(-1);
    }

    public function test_it_can_configure_the_permission()
    {
        $this->assertIsBool($this->field()->permission(function () {
            return true;
        })->hasPermission());
    }

    public function test_it_must_return_boolean_when_permission_set()
    {
        $this->expectException(\Exception::class);
        $this->field()->permission('dax');
    }

    public function test_it_has_default_permission_to_true()
    {
        $this->assertTrue($this->field()->hasPermission());
    }

    public function test_field_is_translatable()
    {
        $field = $this->field();
        $field->setTranslatable();

        $this->assertTrue($field->isTranslatable());

        $field->setTranslatable(false);
        $this->assertFalse($field->isTranslatable());
    }
}