<?php

use Illuminate\Database\Seeder;
use App\Fellowship;

class FellowshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fellowship = new Fellowship();
        $fellowship->university_name = 'Bahir Dar University';
        $fellowship->university_city = 'Bahir Dar';
        $fellowship->campus = 'poly';
        $fellowship->save();
    }
}
