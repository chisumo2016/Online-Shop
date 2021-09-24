<?php
declare(strict_types=1);
namespace Database\Seeders;

use Domains\Catalog\Models\Category;
use Domains\Catalog\Models\Product;
use Domains\Catalog\Models\Range;
use Domains\Catalog\Models\Variant;
use Domains\Customer\Models\Address;
use Domains\Customer\Models\Location;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run() :void
    {
        //Location::factory(50)->create();
        //Address::factory(50)->create();
        //Category::factory(50)->create();
        //Range::factory(50)->create();
        //Product::factory(50)->create();
        Variant::factory(50)->create();

    }
}
