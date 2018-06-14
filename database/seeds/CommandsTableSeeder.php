<?php

use App\Command;
use Illuminate\Database\Seeder;

class CommandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Command::create(['shortname' => 'start', 'name' => 'Start']);
        Command::create(['shortname' => 'help', 'name' => 'Help']);
    }
}
