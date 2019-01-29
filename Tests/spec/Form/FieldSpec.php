<?php

namespace spec\Modules\Rarv\Form;

use Illuminate\Support\HtmlString;
use Modules\Rarv\Form\Field;
use PhpSpec\Laravel\LaravelObjectBehavior;

class FieldSpec extends LaravelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(Field::class);
    }

    public function let()
    {
        $this->beConstructedWith('name', 'normalInput');
    }

    public function it_can_have_name()
    {
        $this->setName('name')->getName()->shouldBe('name');
    }

    public function it_can_have_type()
    {
        $this->setType('normalInput')->getType()->shouldBe('normalInput');
    }

    public function it_can_be_rendered()
    {
        $this->render()->shouldBeAnInstanceOf(HtmlString::class);
    }

    public function it_can_set_get_rules()
    {
        $this->setRules(['required'])->getRules()->shouldHaveCount(1);
    }

    public function it_can_validate_the_field()
    {
        $this->setValue(null)->setRules(['required'])->validate()->shouldReturn(false);
        $this->setValue('dax')->setRules(['required'])->validate()->shouldReturn(true);
    }

    public function it_can_set_get_label()
    {
        $this->setLabel('Question: ')->getLabel()->shouldBe('Question: ');
    }

    public function it_can_get_set_columns()
    {
        $this->setColumn(1)->getColumn()->shouldBe(1);
    }

    public function it_can_not_set_column_invalid()
    {
        $this->shouldThrow()->duringSetColumn('dax');
        $this->shouldThrow()->duringSetColumn(13);
        $this->shouldThrow()->duringSetColumn(-1);
    }

    public function it_can_configure_the_permission()
    {
        $this->permission(function () {
            return true;
        })->hasPermission()->shouldBeBoolean();
    }

    public function it_must_return_boolean_when_permission_set()
    {
        $this->shouldThrow()->duringPermission('dax');
        $this->permission(false)->hasPermission()->shouldBeBoolean();
    }

    public function it_has_default_permission_to_true()
    {
        $this->hasPermission()->shouldBe(true);
    }
}
