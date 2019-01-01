<?php

namespace Modules\Rarv\Parser;

class VariableParser
{
    public function parse($message, $model)
    {
        $variables = $this->extractVariables($message);

        foreach ($variables as &$var) {
        	$message = str_replace('##'.$var.'##', $model->{$var}, $message);
        }

        return $message;
    }

    public function extractVariables($message)
    {
    	preg_match_all('/##([a-zA-Z0-9_]*)##/i', $message, $variables);

    	if(! isset($variables[1])){
    		return false;
    	}

    	return $variables[1];
    }
}
