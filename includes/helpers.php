<?php

use Carbon\Carbon;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;

if (!function_exists('carbon')) {
    function carbon()
    {
        return Carbon::now();
    }
}

if(! function_exists('assetManager')){
	function assetManager(){
		return app(AssetPipeline::class);
	}
}