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

    public function it_has_choices()
    {
    	$this->setChoice(['A', 'B'])->getChoice()->shouldHaveCount(2);
    }

    public function it_can_set_default_choice()
    {
    	$this->setDefault('-- Select --')->getChoice()->shouldHaveCount(3);
    	$this->setChoice([])->setDefault('-- Select --')->getChoice()->shouldHaveCount(1);
    }

}
