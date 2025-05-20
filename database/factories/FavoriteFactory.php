<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'favorite_user_id' => $this->faker->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
