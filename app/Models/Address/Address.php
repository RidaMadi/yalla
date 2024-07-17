<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'addresses';
    protected $fillable = [
        'id',
        'city_name',
        'city_region',
    ];

    public function getCityNameAttribute($value)
    {
        return __($value);
    }

    public function getCityRegionAttribute($value)
    {
        return __($value);
    }

}
