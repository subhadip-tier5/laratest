<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('customers')->insert([
            'name' => str_random(10),
            'email' => str_random(5).'@gmail.com'
        ]);
    }
}
