<?php

use App\Product;
use App\ProductCategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Product::count()) {
            return;
        }

        $faker = \Faker\Factory::create();


        for ($i = 1; $i <= 20; $i++) {
            $name = 'Product No ' . $i;

            Product::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'min_bid' => mt_rand(5, 25),
                'category_id' => ProductCategory::inRandomOrder()->first()->id,
                'close_date' => Carbon::now()->addDays(mt_rand(5, 25))->addHours(mt_rand(0, 12))->startOfHour(),
                'image' => $this->generateFakeImgUrl(),
                'description' => $faker->realText(1000)
            ]);
        }
    }

    private function generateFakeImgUrl()
    {
        $img_cat = ['transport', 'technics'];
        return 'https://lorempixel.com/600/600/' . $img_cat[mt_rand(0, count($img_cat) - 1)] . '/' . mt_rand(1, 10) . '/';
    }
}
