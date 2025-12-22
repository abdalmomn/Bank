<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FaqFactory extends Factory
{

    protected $model = Faq::class;

    public function definition()
    {
        return [
            'question' => $this->faker->sentence(),
            'answer'   => $this->faker->paragraph(),
        ];
    }
}


