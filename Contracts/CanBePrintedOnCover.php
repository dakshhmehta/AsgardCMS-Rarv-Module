<?php

namespace Modules\Rarv\Contracts;

interface CanBePrintedOnCover {
    public function coverText():string;
}