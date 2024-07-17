<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\AppBaseController;
use App\Interfaces\Address\AddressInterface;
use App\Models\Address\Address;

class AddressController extends AppBaseController
{
    protected AddressInterface $addressRepository;
    public function __construct(AddressInterface $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    public function getCities()
    {
        $data = $this->addressRepository->getCity();
        return $this->handleResponse($data['statusCode'],$data['data'],$data['message'],$data['errCode']);
    }
}
