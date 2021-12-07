<?php

use Illuminate\Database\Seeder;
use App\AppImages;

class AppImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AppImages::create([
            'filename' => '123.jpeg',
        ]);
    }
}
