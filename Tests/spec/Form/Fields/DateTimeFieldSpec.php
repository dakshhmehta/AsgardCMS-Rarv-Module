<?php

namespace spec\Modules\Rarv\Form\Fields;

use Illuminate\Support\Collection;
use Modules\Rarv\Form\Field;
use Modules\Rarv\Form\Fields\DateTimeField;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

// shaileshsiju212@gmail.com
class DateTimeFieldSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('due_date');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(DateTimeField::class);
        $this->shouldHaveType(Field::class);
    }

    public function it_can_parse_value()
    {
        $this->setValue('10-01-2019')->getValue()->shouldBe('2019-01-10');
    }
}