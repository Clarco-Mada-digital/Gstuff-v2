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
        1 => [1, 2, 3, 4, 5, 6], // Zürich
        2 => [7, 8, 9, 10, 11, 12, 13], // Bern
        3 => [14, 15, 16, 17, 18, 19], // Fribourg
        4 => [20, 21, 22, 23, 24, 25], // Jura
        5 => [26, 27, 28, 29, 30, 31], // Neuchâtel
        6 => [32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43], // Genève
        7 => [44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60], // Valais
        8 => [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91], // Vaud
    ];

    /**
     * Coordonnées par canton
     */
    protected $coordonneesParCanton = [
        1 => ['lat' => 47.3667, 'lon' => 8.5500], // Zürich
        2 => ['lat' => 46.9480, 'lon' => 7.4474], // Bern
        3 => ['lat' => 46.8050, 'lon' => 7.1530], // Fribourg
        4 => ['lat' => 47.3000, 'lon' => 7.2000], // Jura
        5 => ['lat' => 46.9900, 'lon' => 6.9200], // Neuchâtel
        6 => ['lat' => 46.2044, 'lon' => 6.1432], // Genève
        7 => ['lat' => 46.2000, 'lon' => 7.5500], // Valais
        8 => ['lat' => 46.5200, 'lon' => 6.6300], // Vaud
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
        $genre_id = $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7]);
        $name = $genre_id == 1 ? $this->faker->firstNameFemale() : $this->faker->firstName();
        $nom_salon = $profileType === 'salon' ? $this->faker->firstNameMale() : '';

        // Sélectionne un canton aléatoire
        $canton = $this->faker->numberBetween(1, 8);

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
            'categorie' => $profileType === 'escort'
                ? $this->faker->randomElement([1, 2, 3, 4])
                : $this->faker->randomElement([5, 6, 7, 8]),
            'service' => $this->faker->numberBetween(1, 128),
            'date_naissance' => $dateOfBirth,
            'apropos' => $this->faker->paragraph(3),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('12345678'),
            'remember_token' => Str::random(10),
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
