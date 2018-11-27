<?php

use Carbon\Carbon;

if(! function_exists('carbon')){
	function carbon(){
		return Carbon::now();
	}
}