<?php

namespace Database\Factories;

use App\Models\MailLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MailLogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MailLog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'mailgun_id' => $this->faker->uuid3(),
            'event' => $this->faker->randomElement(MailLog::$events),
            'message_to' => $this->faker->email,
            'message_from' => $this->faker->email,
            'subject' => $this->faker->text(30),
            'timestamp' => $this->faker->dateTimeBetween(Carbon::now()->subDays(15), Carbon::now()),
            'data' => json_encode([]),
        ];
    }
}
