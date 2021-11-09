<?php

use App\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (ProductCategory::count()) {
            return;
        }

        $categories = ['Art', 'Furniture', 'Primitives', 'Maritime', 'Maps, Atlases and Globes', 'Science and Medicine', 'Other Antiques'];

        foreach($categories as $item) {
            ProductCategory::create(['name' => $item]);
        }
    }
}
