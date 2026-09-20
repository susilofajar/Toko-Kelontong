<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['category_id' => 1, 'supplier_id' => 1, 'name' => 'Indomie Goreng', 'barcode' => '8996001010101', 'purchase_price' => 2500, 'selling_price' => 3500, 'stock' => 100],
            ['category_id' => 1, 'supplier_id' => 1, 'name' => 'Chitato Original 68g', 'barcode' => '8996001010102', 'purchase_price' => 8000, 'selling_price' => 10000, 'stock' => 50],
            ['category_id' => 1, 'supplier_id' => 1, 'name' => 'Oreo Vanila 133g', 'barcode' => '8996001010103', 'purchase_price' => 7000, 'selling_price' => 9500, 'stock' => 40],
            ['category_id' => 2, 'supplier_id' => 3, 'name' => 'Aqua 600ml', 'barcode' => '8996001020101', 'purchase_price' => 2000, 'selling_price' => 3000, 'stock' => 200],
            ['category_id' => 2, 'supplier_id' => 3, 'name' => 'Teh Botol Sosro 450ml', 'barcode' => '8996001020102', 'purchase_price' => 3000, 'selling_price' => 4500, 'stock' => 80],
            ['category_id' => 2, 'supplier_id' => 1, 'name' => 'Susu Ultra 250ml', 'barcode' => '8996001020103', 'purchase_price' => 4000, 'selling_price' => 5500, 'stock' => 60],
            ['category_id' => 3, 'supplier_id' => 3, 'name' => 'Beras Premium 5kg', 'barcode' => '8996001030101', 'purchase_price' => 55000, 'selling_price' => 65000, 'stock' => 30],
            ['category_id' => 3, 'supplier_id' => 3, 'name' => 'Gula Pasir 1kg', 'barcode' => '8996001030102', 'purchase_price' => 12000, 'selling_price' => 15000, 'stock' => 45],
            ['category_id' => 3, 'supplier_id' => 1, 'name' => 'Minyak Goreng Bimoli 1L', 'barcode' => '8996001030103', 'purchase_price' => 15000, 'selling_price' => 18000, 'stock' => 35],
            ['category_id' => 4, 'supplier_id' => 1, 'name' => 'Kecap Manis ABC 275ml', 'barcode' => '8996001040101', 'purchase_price' => 8000, 'selling_price' => 11000, 'stock' => 25],
            ['category_id' => 4, 'supplier_id' => 1, 'name' => 'Saos Sambal ABC 335ml', 'barcode' => '8996001040102', 'purchase_price' => 9000, 'selling_price' => 12000, 'stock' => 20],
            ['category_id' => 5, 'supplier_id' => 2, 'name' => 'Sabun Lifebuoy 75g', 'barcode' => '8996001050101', 'purchase_price' => 3000, 'selling_price' => 4500, 'stock' => 55],
            ['category_id' => 5, 'supplier_id' => 5, 'name' => 'Deterjen Daia 900g', 'barcode' => '8996001050102', 'purchase_price' => 11000, 'selling_price' => 14000, 'stock' => 30],
            ['category_id' => 5, 'supplier_id' => 2, 'name' => 'Shampo Sunsilk 170ml', 'barcode' => '8996001050103', 'purchase_price' => 15000, 'selling_price' => 19000, 'stock' => 8],
            ['category_id' => 7, 'supplier_id' => 4, 'name' => 'Paracetamol Strip', 'barcode' => '8996001070101', 'purchase_price' => 3000, 'selling_price' => 5000, 'stock' => 15],
            ['category_id' => 7, 'supplier_id' => 4, 'name' => 'Vitamin C 100mg', 'barcode' => '8996001070102', 'purchase_price' => 5000, 'selling_price' => 8000, 'stock' => 12],
            ['category_id' => 8, 'supplier_id' => 4, 'name' => 'Pulpen Standard AE7', 'barcode' => '8996001080101', 'purchase_price' => 2000, 'selling_price' => 3000, 'stock' => 100],
            ['category_id' => 9, 'supplier_id' => 5, 'name' => 'Tisu Paseo 250 Sheet', 'barcode' => '8996001090101', 'purchase_price' => 8000, 'selling_price' => 11000, 'stock' => 5],
            ['category_id' => 10, 'supplier_id' => 2, 'name' => 'Susu Dancow 400g', 'barcode' => '8996001100101', 'purchase_price' => 35000, 'selling_price' => 42000, 'stock' => 15],
            ['category_id' => 10, 'supplier_id' => 4, 'name' => 'Popok Mamy Poko M 34', 'barcode' => '8996001100102', 'purchase_price' => 45000, 'selling_price' => 55000, 'stock' => 10],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
