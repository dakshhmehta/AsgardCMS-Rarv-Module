<?php

namespace spec\Modules\Rarv\Button\Repositories;

use Modules\Rarv\Button\Button;
use Modules\Rarv\Button\Repositories\CreateButton;
use Modules\Rarv\Table\Table;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class CreateButtonSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Button::class);
    }

    public function let()
    {
        $table = new Table('accounting.invoices');
        $this->beConstructedWith($table);
    }

    public function it_can_get_correct_info()
    {
        $this->getLabel()->shouldBe('Add');
        $this->getUrl()->shouldBeString();
        $this->getColor()->shouldBe('success');
        $this->getIcon()->shouldBe('fa fa-plus');
    }
}
