<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'job_title' => $this->faker->jobTitle(),
            'location' => $this->faker->city(),
            'status' => 'active',
            'employee_type' => $this->faker->randomElement(['employee', 'contractor']),
            'join_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'source' => 'local',
        ];
    }
}
