<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    // use HasUlids;

    protected $fillable = [
        'server_name',
        'hourly_price',
        'ram',
        'vcpu',
        'disk_storage',
        'server_provider',
    ];

    


}
