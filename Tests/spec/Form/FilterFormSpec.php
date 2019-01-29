<?php

namespace spec\Modules\Rarv\Form;

use Modules\Rarv\Form\FilterForm;
use Modules\Rarv\Form\FormBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FilterFormSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('filter-form');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FilterForm::class);
    }

    public function it_render_the_filter_form_view()
    {
        return $this->viewPath(new FormBuilder)->shouldBe('rarv::admin.filter-form');
    }
}
