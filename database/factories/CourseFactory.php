<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Facade;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3,true), // give me 3 words | if it false it will return array 
            'image' => fake()->imageUrl(), // fake image url
            'content' => fake()->sentence(), // give me sentence
            'price' => fake()->numberBetween(10,100), // chose number between 10 and 100
            'hours' => fake()->randomElement([40,60,80,100]) // choose one of thoses
        ];
    }
}
