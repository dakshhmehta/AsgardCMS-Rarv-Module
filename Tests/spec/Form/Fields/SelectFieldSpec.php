<?php

namespace spec\Modules\Rarv\Form\Fields;

use Modules\Rarv\Form\Field;
use Modules\Rarv\Form\Fields\SelectField;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SelectFieldSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('gender', ['m' => 'Male', 'f' => 'Female']);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(SelectField::class);
        $this->shouldHaveType(Field::class);
    }
}
