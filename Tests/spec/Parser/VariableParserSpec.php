<?php

namespace spec\Modules\Rarv\Parser;

use Modules\Rarv\Entities\User;
use Modules\Rarv\Parser\VariableParser;
use PhpSpec\Laravel\LaravelObjectBehavior;
use Prophecy\Argument;

class VariableParserSpec extends LaravelObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VariableParser::class);
    }

    public function let()
    {
    }

    public function it_can_parse_basic_attributes()
    {
    	$user = new User([
    		'first_name' => 'Daksh',
            'last_name' => 'Mehta',
    	]);

    	$this->parse('Hello ##first_name## ##last_name##', $user)->shouldReturn('Hello Daksh Mehta');
    }

    public function it_can_extract_correct_variables()
    {
        $this->extractVariables('Hi ##first## ##last##')->shouldReturn(['first', 'last']);
    }
}
