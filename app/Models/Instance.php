<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Instance extends Model
{
    protected $fillable = [
        'server_id',
        'user_id',
        'product_id',
        'meta'
    ];



    public function product(): BelongsTo {
        return $this->belongsTo(Product::class);
    }

    public function server(): BelongsTo {
        return $this->belongsTo(Server::class);
    }
}
