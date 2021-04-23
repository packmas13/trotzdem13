<?php

namespace Database\Factories;

use App\Models\Banner;
use App\Models\Handover;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class HandoverFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Handover::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'banner_id' => $this->faker->randomElement(Banner::pluck('id')),
            'received_at' => $this->faker->date('Y-m-d', '2021-09-01'),
        ];
    }
}
