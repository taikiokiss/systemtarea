<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition()
    {
        return [
			'name' => $this->faker->name,
			'jefe_grupo' => $this->faker->name,
			'miembro_grupo' => $this->faker->name,
        ];
    }
}
