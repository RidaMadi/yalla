<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemporaryPhone extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'temporary_phones';
    protected $fillable = [
        'id',
        'phone',
        'code',
        'expired_at',
    ];

}
