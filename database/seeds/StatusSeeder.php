<?php

use Illuminate\Database\Seeder;
use App\Status ;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Status::create([
    		'name' => 'new',
    	]);
        Status::create([
    		'name' => 'second hand',
    	]);
        Status::create([
    		'name' => 'pre-loved',
        ]);
        Status::create([
    		'name' => 'old',
    	]);
    }
}
