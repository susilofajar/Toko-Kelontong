<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['name' => 'PT Indofood Sukses Makmur', 'address' => 'Jakarta', 'phone' => '021-1234567', 'email' => 'info@indofood.com'],
            ['name' => 'PT Unilever Indonesia', 'address' => 'Jakarta', 'phone' => '021-7654321', 'email' => 'info@unilever.co.id'],
            ['name' => 'CV Sumber Makmur', 'address' => 'Surabaya', 'phone' => '031-9876543', 'email' => 'sumber@makmur.com'],
            ['name' => 'UD Jaya Abadi', 'address' => 'Semarang', 'phone' => '024-1112233', 'email' => 'jayaabadi@mail.com'],
            ['name' => 'PT Wings Surya', 'address' => 'Surabaya', 'phone' => '031-3344556', 'email' => 'info@wings.co.id'],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
