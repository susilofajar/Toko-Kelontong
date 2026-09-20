<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Makanan Ringan', 'description' => 'Snack, keripik, biskuit'],
            ['name' => 'Minuman', 'description' => 'Air mineral, jus, susu, kopi'],
            ['name' => 'Sembako', 'description' => 'Beras, gula, minyak, tepung'],
            ['name' => 'Bumbu Dapur', 'description' => 'Garam, merica, kecap, saus'],
            ['name' => 'Sabun & Deterjen', 'description' => 'Sabun mandi, sabun cuci, deterjen'],
            ['name' => 'Rokok', 'description' => 'Berbagai merek rokok'],
            ['name' => 'Obat-obatan', 'description' => 'Obat umum dan vitamin'],
            ['name' => 'Alat Tulis', 'description' => 'Pulpen, buku, penghapus'],
            ['name' => 'Perlengkapan Rumah', 'description' => 'Tisu, plastik, kantong sampah'],
            ['name' => 'Produk Bayi', 'description' => 'Susu bayi, popok, bedak'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
