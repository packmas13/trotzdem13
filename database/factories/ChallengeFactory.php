<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChallengeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Challenge::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title,
            'description' => $this->faker->paragraph,
            'author_id' => User::factory(),
            'source' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 15),
            'category_id' => $this->faker->randomElement(Category::pluck('id')),
            // 'team_id' => Team::factory(),
            'published_at' => now(), // by default: orga challenges
        ];
    }
}
