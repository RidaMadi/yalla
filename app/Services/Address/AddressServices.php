<?php

namespace App\Services\Address;

use App\Interfaces\Address\AddressInterface;
use App\Models\Address\Address;

class AddressServices implements AddressInterface
{

    public function getCity()
    {
        $cities = Address::selectRaw('MIN(id) as id, city_name')
            ->groupBy('city_name')
            ->get();

        return [
            'statusCode' => 200,
            'data' => $cities,
            'message' => __("Here are all cities"),
            'errCode' => 0,
        ];
    }
}
