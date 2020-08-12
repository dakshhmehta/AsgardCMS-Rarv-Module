<?php

namespace Modules\Rarv\Tests\Unit;

use Modules\Core\Tests\BaseTestCase;
use Modules\Rarv\Form\Field;

class FieldTest extends BaseTestCase {
    protected function field():Field
    {
        return (new Field('name', 'text'));
    }

    public function test_field_is_testable()
    {
        $field = $this->field();
        $field->setTranslatable();

        $this->assertTrue($field->isTranslatable());

        $field->setTranslatable(false);
        $this->assertFalse($field->isTranslatable());
    }
}