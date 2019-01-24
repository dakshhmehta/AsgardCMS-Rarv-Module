<?php

namespace spec\Modules\Rarv\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Button\Button;
use Modules\Rarv\Table\Table;
use PhpSpec\Laravel\LaravelObjectBehavior;

class TableSpec extends LaravelObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('faq');
    }

    public function it_is_initializable()
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
            'id', 'question',
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

    public function it_can_set_get_actions()
    {
        $editBtn   = new Button('Edit', '##id##/edit');
        $deleteBtn = new Button('Delete', '##id##/delete');

        // We have added two buttons, and 1 is system default for create.
        $this->setLinks([$editBtn, $editBtn])->getLinks()->shouldHaveCount(3);
        $this->addLink($deleteBtn)->getLinks()->shouldHaveCount(4);
    }
}
