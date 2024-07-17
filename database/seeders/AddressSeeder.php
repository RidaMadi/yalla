<?php

namespace Database\Seeders;

use App\Models\Address\Address;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $addresses = [
            [
                'city_name' => 'Damascus',
                'city_region' => 'Qudsaya suburb',
            ],
        ];

        foreach ($addresses as $address) {
            if (!Address::where('city_name', $address['city_name'])->where('city_region', $address['city_region'])->exists())
                Address::create($address);
        }
    }
}
