<?php

namespace Database\Factories;

use App\Models\Troop;
use App\Models\Banner;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'leader_id' => User::factory(),
            'troop_id' => $this->faker->randomElement(Troop::pluck('id')),
            'banner_id' => $this->faker->randomElement(Banner::pluck('id')),
            'size' => $this->faker->numberBetween(1, 15),
            'location' => [
                'lat' => $this->faker->randomFloat(5, 47.6, 48.5),
                'lng' => $this->faker->randomFloat(5, 11.2, 13),
            ],
            'radius' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'join_code' => $this->faker->unique()->lexify('????????'),
            'approved_at' => now(),
        ];
    }


    public function pending(): Factory
    {
        return $this->state([
            'approved_at' => null,
        ]);
    }

    public function configure()
    {
        return $this->afterCreating(function (Team $team) {
            $team->users()->attach($team->leader_id);
        });
    }
}
