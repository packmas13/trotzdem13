<?php

namespace Database\Factories;

use App\Models\Stamm;
use Illuminate\Database\Eloquent\Factories\Factory;

class StammFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stamm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
