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
            'troop_id' => Troop::factory(),
            'banner_id' => Banner::factory(),
            'size' => $this->faker->numberBetween(1, 15),
            'location' => [
                'lat' => $this->faker->randomFloat(5, 47.38488, 48.56617),
                'lng' => $this->faker->randomFloat(5, 10.66794, 13.38981),
            ],
            'radius' => $this->faker->randomElement([10, 100, 1000]),
            'join_code' => $this->faker->word,
            'approved_at' => now(),
        ];
    }


    public function pending():Factory
    {
        return $this->state([
            'approved_at' => null,
        ]);
    }
}
