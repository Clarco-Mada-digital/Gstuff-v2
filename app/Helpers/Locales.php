<?php

namespace App\Helpers;

class Locales
{
    /**
     * Liste des locales supportées
     */
    public const SUPPORTED = [
        'fr' => [
            'name' => 'Français',
            'native' => 'Français',
            'flag' => 'fr',
            'direction' => 'ltr',
        ],
        'en-US' => [
            'name' => 'English (US)',
            'native' => 'English',
            'flag' => 'us',
            'direction' => 'ltr',
        ],
        'es' => [
            'name' => 'Español',
            'native' => 'Español',
            'flag' => 'es',
            'direction' => 'ltr',
        ],
        'de' => [
            'name' => 'Deutsch',
            'native' => 'Deutsch',
            'flag' => 'de',
            'direction' => 'ltr',
        ],
        'it' => [
            'name' => 'Italiano',
            'native' => 'Italiano',
            'flag' => 'it',
            'direction' => 'ltr',
        ],
    ];

    /**
     * Liste des codes de locales supportés
     */
    public const SUPPORTED_CODES = [
        'fr', 'en-US', 'es', 'de', 'it'
    ];

    /**
     * Locale par défaut
     */
    public const DEFAULT = 'fr';

    /**
     * Locale de fallback
     */
    public const FALLBACK = 'fr';

    /**
     * Vérifie si une locale est supportée
     */
    public static function isSupported(string $locale): bool
    {
        return in_array($locale, self::SUPPORTED_CODES);
    }

    /**
     * Récupère les informations d'une locale
     */
    public static function getInfo(string $locale): ?array
    {
        return self::SUPPORTED[$locale] ?? null;
    }

    /**
     * Récupère le nom d'une locale
     */
    public static function getName(string $locale): string
    {
        return self::getInfo($locale)['name'] ?? $locale;
    }

    /**
     * Récupère le nom natif d'une locale
     */
    public static function getNativeName(string $locale): string
    {
        return self::getInfo($locale)['native'] ?? $locale;
    }

    /**
     * Récupère le code du drapeau d'une locale
     */
    public static function getFlag(string $locale): string
    {
        return self::getInfo($locale)['flag'] ?? substr($locale, 0, 2);
    }

    /**
     * Récupère la direction d'une locale
     */
    public static function getDirection(string $locale): string
    {
        return self::getInfo($locale)['direction'] ?? 'ltr';
    }
}
