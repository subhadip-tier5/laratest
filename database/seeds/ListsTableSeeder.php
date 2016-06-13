<?php

use Illuminate\Database\Seeder;

class ListsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        //
        DB::table('test_lists')->insert([
            'title' => str_random(10),
            'slug' => str_random(5)
        ]);
    }
}
