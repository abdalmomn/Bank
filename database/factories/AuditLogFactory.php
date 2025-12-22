<?php

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    public function definition()
    {
        return [
            'entity_type' => 'transaction',
            'entity_id'   => (string) $this->faker->uuid(),
            'action'      => $this->faker->sentence(3),
            'before'      => [],
            'after'       => [],
            'user_id'     => User::inRandomOrder()->first()->id,
            'ip'          => $this->faker->ipv4(),
        ];
    }
}

