<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasUlids;

    protected $fillable = [
        'product_name',
        'hourly_price',
        'ram',
        'vcpu',
        'disk_storage',
        'product_provider',
    ];

    


}
