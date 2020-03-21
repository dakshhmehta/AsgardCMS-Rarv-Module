<?php

namespace spec\Modules\Rarv\Table;

use Illuminate\View\View;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Table\Table;
use Modules\Rarv\Table\TableBuilder;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TableBuilderSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(TableBuilder::class);
    }

    public function table()
    {
        return (new Table('faq.faqs'))
            ->setRepository(PageRepository::class) // Fake repository to passes test
            ->addColumn('question');
    }

    public function it_can_set_get_table()
    {
        $this->setTable($this->table())->getTable()->shouldBeAnInstanceOf(Table::class);
    }

    public function it_cant_be_viewed_without_setting_a_table()
    {
        $this->shouldThrow()->duringView();
    }

    public function it_can_be_viewed()
    {
        $this->setTable($this->table())->view()->shouldBeAnInstanceOf(View::class);
    }

    public function it_can_get_correct_module()
    {
        $this->setTable($this->table())->getModule()->shouldBe('faq');
    }

    public function it_can_get_correct_entity()
    {
        $this->setTable($this->table())->getEntity()->shouldBe('faqs');
    }
}
