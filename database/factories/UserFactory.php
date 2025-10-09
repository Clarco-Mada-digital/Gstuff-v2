<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected $model = User::class;
    protected static ?string $password;

    /**
     * Liste des villes par canton
     */
    protected $villesParCanton = [
        1 => [1, 2, 3, 4, 5, 6], // Vaud
        2 => [7, 8, 9, 10, 11, 12,13], // Genève
        3 => [14, 15, 16,17,18,19,20], // Berne
        4 => [21,22,23,24,25,26], // Suisse Alémanique
        5 => [27, 28, 29, 30, 31, 32], // Jura
        6 => [33, 34, 35], // Fribourg
        7 => [36, 37, 38, 39 ,40, 41, 42, 43, 44, 45, 46, 47], // Neuchâtel
        8 => [48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68], // Valais
        9 => [69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91], // Vaud
    ];

    /**
     * Coordonnées par canton
     */
    

    protected $coordonneesParCanton = [
        1 => ['lat' => 47.3769, 'lon' => 8.5417], // Suisse alémanique
        2 => ['lat' => 47.3769, 'lon' => 8.5417], // Zurich
        3 => ['lat' => 46.9481, 'lon' => 7.4474], // Berne 
        4 => ['lat' => 46.8065, 'lon' => 7.1618], // Fribourg 
        5 => ['lat' => 47.3676, 'lon' => 7.3454], // Jura 
        6 => ['lat' => 46.9896, 'lon' => 6.9293], // Neuchâtel 
        7 => ['lat' => 46.2044, 'lon' => 6.1432], // Genève 
        8 => ['lat' => 46.2276, 'lon' => 7.3585], // Valais 
        9 => ['lat' => 46.5197, 'lon' => 6.6323], // Vaud 
    ];
 
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Calculer une date de naissance pour s'assurer que l'utilisateur a plus de 18 ans
        $dateOfBirth = $this->faker->dateTimeBetween('-40 years', '-18 years');
        $profileType = $this->faker->randomElement(['escorte', 'salon']);
        $genre_id = $this->faker->randomElement([1, 2, 3]);
        $name = $genre_id == 1 ? $this->faker->firstNameFemale() : $this->faker->firstName();
        $nom_salon = $profileType === 'salon' ? $this->faker->firstNameMale() : '';

        

        // Sélectionne un canton aléatoire
        $canton = $this->faker->numberBetween(1, 9);

        // Sélectionne une ville qui appartient au canton sélectionné
        $ville = $this->faker->randomElement($this->villesParCanton[$canton]);

        return [
            'profile_type' => $profileType === 'escorte' ? 'escorte' : 'salon',
            'email' => $this->faker->unique()->safeEmail,
            'genre_id' => $genre_id,
            'prenom' => $name,
            'nom_salon' => $nom_salon,
            'canton' => $canton,
            'ville' => $ville,
            'lat' => $this->faker->randomFloat(6, $this->coordonneesParCanton[$canton]['lat'] - 0.05, $this->coordonneesParCanton[$canton]['lat'] + 0.05),
            'lon' => $this->faker->randomFloat(6, $this->coordonneesParCanton[$canton]['lon'] - 0.05, $this->coordonneesParCanton[$canton]['lon'] + 0.05),
            'categorie' => $profileType === 'escorte'
                ? $this->faker->randomElement([1, 2, 3, 4])
                : $this->faker->randomElement([5, 6, 7, 8]),
            'service' => $this->faker->numberBetween(1, 128),
            'date_naissance' => $dateOfBirth,
            'apropos' => $this->faker->paragraph(3),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('12345678'),
            'remember_token' => Str::random(10),
            'nombre_fille_id' => $profileType === 'salon' ? $this->faker->numberBetween(1, 3) : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
