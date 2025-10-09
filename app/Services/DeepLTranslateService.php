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

    /**
     * Translate text to the target language
     *
     * @param string|array $text Text(s) to translate
     * @param string $targetLanguage Target language code (e.g., 'fr', 'en-US')
     * @param string|null $sourceLanguage Source language code (optional)
     * @return string|array
     * @throws \Exception
     */
    public function translate($text, string $targetLanguage, ?string $sourceLanguage = null)
    {
        try {
            if (empty($text)) {
                throw new \InvalidArgumentException('Text to translate cannot be empty');
            }
            
            $result = $this->client->translateText($text, $sourceLanguage, $targetLanguage);
            
            // Si on a un tableau de résultats, on retourne un tableau de textes
            if (is_array($result)) {
                return array_map(fn($item) => $item->text, $result);
            }
            
            // Sinon on retourne le texte unique
            return $result->text;
            
        } catch (\Exception $e) {
            \Log::error('DeepL Translation Error: ' . $e->getMessage());
            throw new \Exception('Translation failed: ' . $e->getMessage());
        }
    }
}
