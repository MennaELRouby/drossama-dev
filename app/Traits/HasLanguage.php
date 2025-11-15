<?php

namespace App\Traits;

trait HasLanguage{
    
    protected $lang;

    public function initializeHasLanguage()
    {
        // Set the language variable
        $this->lang = app()->getLocale();
    }
}
