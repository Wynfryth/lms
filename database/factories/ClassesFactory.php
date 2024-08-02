<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Classes>
 */


class ClassesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = $this->faker->randomNumber(5, true);
        $category_id = $this->faker->randomNumber(1, true);
        $desc = $this->faker->unique()->words(10, true);
        return [
            'class_code' => $code,
            'class_category_id' => $category_id,
            'class_title' => generateCourseName(),
            'class_desc' => $desc,
            'class_period' => null,
            'tc_id' => null,
            'is_active' => 1,
            'start_eff_date' => null,
            'end_eff_date' => null,
            'loc_type_id' => null,
            'loc_id' => null,
        ];
    }
}
