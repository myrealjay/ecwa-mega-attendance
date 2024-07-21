<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'category_id' => 1,
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'number_of_questions' => 10,
            'end_date' => date('Y-m-d H:i:s', strtotime('+ 3 month '.now()))
        ];
    }
}
