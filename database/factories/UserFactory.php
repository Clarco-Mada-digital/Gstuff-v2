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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Calculer une date de naissance pour s'assurer que l'utilisateur a plus de 18 ans
        $dateOfBirth = $this->faker->dateTimeBetween('-40 years', '-18 years');
        $profileType = $this->faker->randomElement(['escorte', 'salon']);
        $genre = $this->faker->randomElement(['femme', 'homme', 'trans', 'gay', 'bisexuelle', 'lesbienne', 'queer']);
        $prenom = $genre == 'femme' ? $this->faker->firstNameFemale() : $this->faker->firstName();
        $nom_salon = $profileType === 'salon' ? $this->faker->firstNameMale() : '';

        return [
            'profile_type' => $profileType,
            'email' => $this->faker->unique()->safeEmail,
            'genre' => $genre,
            'prenom' => $prenom,
            'nom_salon' => $nom_salon,
            'canton' => $this->faker->numberBetween(1, 9),
            'ville' => $this->faker->numberBetween(1, 91),
            'categorie' => $this->faker->randomElement(
                $this->faker->randomElement(['escort', 'salon']) === 'escort' 
                    ? [1, 2, 3, 4] 
                    : [5, 6, 7, 8]
            ),
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
