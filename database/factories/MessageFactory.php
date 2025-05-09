<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'from_id' => $this->faker->numberBetween(1, 10),
            'to_id' => $this->faker->numberBetween(1, 10),
            'body' => $this->faker->sentence,
            'attachment' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
