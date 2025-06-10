<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Commentaire;

class CommentaireFactory extends Factory
{
    protected $model = Commentaire::class;

    public function definition()
    {
        $content = [
            [
                'fr' => 'Le site est bien pensé, sécurisé et vraiment agréable à utiliser.',
                'en' => 'The site is well-designed, secure, and really pleasant to use.',
                'es-US' => 'El sitio está bien diseñado, es seguro y realmente agradable de usar.',
                'de' => 'Die Seite ist gut gestaltet, sicher und wirklich angenehm zu nutzen.',
                'it' => 'Il sito è ben progettato, sicuro e davvero piacevole da usare.',
            ],
            [
                'fr' => 'Les profils sont authentiques, ce qui change des autres plateformes.',
                'en' => 'The profiles are authentic, which sets it apart from other platforms.',
                'es-US' => 'Los perfiles son auténticos, lo que lo diferencia de otras plataformas.',
                'de' => 'Die Profile sind authentisch, was die Plattform von anderen unterscheidet.',
                'it' => 'I profili sono autentici, il che lo distingue dalle altre piattaforme.',
            ],
            [
                'fr' => 'Très belle expérience ! L’interface est simple à utiliser.',
                'en' => 'Great experience! The interface is easy to use.',
                'es-US' => '¡Muy buena experiencia! La interfaz es fácil de usar.',
                'de' => 'Sehr schöne Erfahrung! Die Benutzeroberfläche ist einfach zu bedienen.',
                'it' => 'Bellissima esperienza! L’interfaccia è facile da usare.',
            ],
            [
                'fr' => 'J’ai apprécié le sérieux du site et la qualité des échanges.',
                'en' => 'I appreciated the seriousness of the site and the quality of the interactions.',
                'es-US' => 'Aprecié la seriedad del sitio y la calidad de los intercambios.',
                'de' => 'Ich habe die Seriosität der Seite und die Qualität der Gespräche geschätzt.',
                'it' => 'Ho apprezzato la serietà del sito e la qualità degli scambi.',
            ],
            [
                'fr' => 'La modération est efficace, on se sent en sécurité. C’est un vrai plus par rapport à d’autres plateformes.',
                'en' => 'The moderation is effective, and you feel safe. It’s a real advantage over other platforms.',
                'es-US' => 'La moderación es eficaz y te hace sentir seguro. Es una verdadera ventaja frente a otras plataformas.',
                'de' => 'Die Moderation ist effektiv, man fühlt sich sicher. Das ist ein echter Vorteil gegenüber anderen Plattformen.',
                'it' => 'La moderazione è efficace e ti fa sentire al sicuro. È un vero vantaggio rispetto ad altre piattaforme.',
            ]
        ];
        

        return [
            'content' => $this->faker->randomElement($content),
            'user_id' => User::inRandomOrder()->first()->id,
            'is_approved' => $this->faker->boolean(60),
        ];
    }
}
