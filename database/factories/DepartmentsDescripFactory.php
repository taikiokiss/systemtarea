<?php

namespace Database\Factories;

use App\Models\DepartmentsDescrip;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DepartmentsDescripFactory extends Factory
{
    protected $model = DepartmentsDescrip::class;

    public function definition()
    {
        return [
			'departments_id' => $this->faker->name,
			'subtarea_descrip' => $this->faker->name,
			'usuario_asignado' => $this->faker->name,
			'tiempo_demora' => $this->faker->name,
			'estado' => $this->faker->name,
        ];
    }
}
