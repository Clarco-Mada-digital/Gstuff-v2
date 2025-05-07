<?php

namespace App\Services;

use DeepL\DeepLClient;

class DeepLTranslateService
{
    protected $client;

    public function __construct()
    {
        $authKey = env('DEEPL_API_KEY'); // Assurez-vous de définir cette clé dans votre fichier .env
        $this->client = new DeepLClient($authKey);
    }

    public function translate($text, $targetLanguage, $sourceLanguage = null)
    {
        $result = $this->client->translateText($text, $sourceLanguage, $targetLanguage);
        return $result->text;
    }
}
