<?php

namespace Database\Seeders;

use App\Models\Domain;
use App\Models\MailLog;
use Illuminate\Database\Seeder;

class MailLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Domain::factory()
            ->count(5)
            ->has(MailLog::factory()->count(100))
            ->create();
    }
}
