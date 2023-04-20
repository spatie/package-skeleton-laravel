<?php

namespace VendorName\Skeleton\Database\Seeders;

use Illuminate\Database\Seeder;
use VendorName\Skeleton\Database\Seeders\ModelSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ModelSeeder::class, // for example
        ]);
    }
}
