<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ZipsSeeder::class);
        $this->call(ColoniesSeeder::class);
        $this->call(SectionsSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsSeeder::class);
    }
}
