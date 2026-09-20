<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No. 10'],
            ['name' => 'Siti Rahayu', 'phone' => '081298765432', 'address' => 'Jl. Sudirman No. 25'],
            ['name' => 'Ahmad Fadli', 'phone' => '085611223344', 'address' => 'Jl. Gatot Subroto No. 5'],
            ['name' => 'Dewi Lestari', 'phone' => '087899887766', 'address' => 'Jl. Ahmad Yani No. 15'],
            ['name' => 'Rizky Pratama', 'phone' => '082155667788', 'address' => 'Jl. Diponegoro No. 8'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
