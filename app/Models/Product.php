<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // use HasUlids;

    protected $fillable = [
        'uuid', 
        'product_name',
        'hourly_price',
        'ram',
        'vcpu',
        'disk_storage',
        'slug', 
        'product_provider',
        'provider_price'
    ];

    


}
