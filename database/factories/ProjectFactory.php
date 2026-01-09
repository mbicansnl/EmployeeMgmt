<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Domain;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'domain_id' => Domain::factory(),
            'name' => $this->faker->bs(),
            'code' => strtoupper($this->faker->bothify('PRJ-###')),
            'description' => $this->faker->sentence(),
            'status' => 'active',
            'start_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
