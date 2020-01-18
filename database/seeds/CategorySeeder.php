<?php

use Illuminate\Database\Seeder;
use App\Category ;


class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

    	Category::create([
    		'name' => 'property1',
    	]);
    	Category::create([
    		'name' => 'property2',
    	]);
    	Category::create([
    		'name' => 'property3',
    	]);
    	Category::create([
    		'name' => 'cars for sale',
    	]);
    	Category::create([
    		'name' => 'mobile phones & tablets',
    	]);
    	Category::create([
    		'name' => "Women's Fashion",
		]);
		Category::create([
    		'name' => "Men's Fashion",
    	]);
		Category::create([
    		'name' => "Health & Beauty",
    	]);
		Category::create([
    		'name' => "Babies & Kids",
    	]);
		Category::create([
    		'name' => "Electronics",
    	]);
		Category::create([
    		'name' => "Home & Furniture",
    	]);
		Category::create([
    		'name' => "Home Services",
    	]);
    }
}
