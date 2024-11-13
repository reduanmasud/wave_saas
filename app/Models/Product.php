<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'server_id',
        'base_price',
        'product_type',
        'provisioned_at',
        'destroyed_at',
        'durations',
        'total_price',
        'verified_at',
        'verified_by',
        'trxID',
    ];



    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'base_price' => 'double',
        'provisioned_at' => 'datetime',
        'destoryed_at' => 'datetime',
        'total_price' => 'double',
    ];


    /**
     * Get the user that owns the product.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the server associated with the product.
     */
    public function server(): BelongsTo
    {
        return $this->belongsTo(Server::class);
    }

}
