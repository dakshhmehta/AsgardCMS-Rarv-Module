<?php

namespace spec\Modules\Rarv\Form\Fields;

use Illuminate\Support\Collection;
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

    public function it_sets_the_array_into_collection()
    {
        $this->setChoice(['' => 'Default', 'm' => 'Male']);

        $this->getChoice()->shouldBeAnInstanceOf(Collection::class);
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

    public function it_can_persist_keys_when_setting_default()
    {
        $this->setChoice([
            2 => 'Daksh',
            3 => 'Tirth',
        ]);

        $this->setDefault('Mahesh');
        $this->getChoice()
            ->shouldHaveKey(2);

        $this->getChoice()
            ->shouldHaveKey(3);

        $this->getChoice()
            ->shouldHaveKey('');
    }
}
