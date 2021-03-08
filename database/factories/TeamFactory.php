<?php

namespace Database\Factories;

use App\Models\Stamm;
use App\Models\Stufe;
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
            'stamm_id' => Stamm::factory(),
            'stufe_id' => Stufe::factory(),
            'size' => $this->faker->numberBetween(1, 15),
            'location' => [
                'lat' => $this->faker->randomFloat(5, 47.38488, 48.56617),
                'lng' => $this->faker->randomFloat(5, 10.66794, 13.38981),
            ],
            'radius' => $this->faker->randomElement([10, 100, 1000]),
        ];
    }
}
