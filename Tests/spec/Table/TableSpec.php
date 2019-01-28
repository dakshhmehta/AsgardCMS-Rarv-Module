<?php

namespace spec\Modules\Rarv\Table;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Faq\Http\Form\FaqFilterForm;
use Modules\Page\Repositories\PageRepository;
use Modules\Rarv\Button\Button;
use Modules\Rarv\Form\FilterForm;
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

    public function it_returns_buttons_with_permission_only($value='')
    {
        $createBtn = new Button('Create', '/create');
        $createBtn->permission(false);

        $this->setButtons([$createBtn])->getButtons()->shouldHaveCount(1);
    }

    public function it_returns_links_with_permission_only($value='')
    {
        $createBtn = new Button('Create', '/create');
        $createBtn->permission(false);

        $this->setLinks([$createBtn])->getLinks()->shouldHaveCount(2);
    }

    public function it_can_set_get_actions()
    {
        $editBtn   = new Button('Edit', '##id##/edit');
        $deleteBtn = new Button('Delete', '##id##/delete');

        // We have added two buttons, and 1 is system default for create.
        $this->setLinks([$editBtn, $editBtn])->getLinks()->shouldHaveCount(3);
        $this->addLink($deleteBtn)->getLinks()->shouldHaveCount(4);
    }

    public function it_can_set_get_filters()
    {
        $this->setFilterForm(new FaqFilterForm('faq.faqfilter'))->getFilterForm()
            ->shouldBeAnInstanceOf(FilterForm::class);

        $this->setFilterForm(FaqFilterForm::class)->getFilterForm()->shouldBeAnInstanceOf(FilterForm::class);
    }
}
