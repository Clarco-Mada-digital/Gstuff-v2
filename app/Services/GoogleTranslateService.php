<?php

// app/Services/GoogleTranslateService.php
namespace App\Services;

use Stichoza\GoogleTranslate\GoogleTranslate;

class GoogleTranslateService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new GoogleTranslate();
    }

    public function translate($text, $targetLanguage, $sourceLanguage = 'auto')
    {
        return $this->translator->setSource($sourceLanguage)
                                ->setTarget($targetLanguage)
                                ->translate($text);
    }
}
