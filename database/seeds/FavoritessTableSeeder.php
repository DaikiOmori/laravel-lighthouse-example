<?php

use Illuminate\Database\Seeder;

class FavoritessTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->truncate();
        factory(App\Models\Favorite::class, 50)->create();
    }
}
