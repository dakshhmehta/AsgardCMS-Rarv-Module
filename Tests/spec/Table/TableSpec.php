<?php

namespace spec\Modules\Rarv\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class TableSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('faq');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Table::class);
    }

    public function it_can_set_get_repository()
    {
        $this->setRepository(PageRepository::class)->getRepository()
            ->shouldBeAnInstanceOf(PageRepository::class);
    }

    public function it_can_set_get_columns()
    {
        $this->setColumns([
            'id', 'question'
        ]);

        $this->addColumn('answer')->getColumns()->shouldHaveCount(3);
    }

    public function it_can_return_records()
    {
        $this->addColumn('question')->setRepository(PageRepository::class)
            ->getRecords()->shouldBeAnInstanceOf(LengthAwarePaginator::class);
    }

    public function it_can_set_get_buttons()
    {
        $createBtn = new Button('Create', '/create');
        $deleteBtn = new Button('Edit', 'edit/1');

        // We have added two buttons, and 1 is system default for create.
        $this->setButtons([$createBtn, $deleteBtn])->getButtons()->shouldHaveCount(3);
        $this->addButton($createBtn)->getButtons()->shouldHaveCount(3);
    }
}
