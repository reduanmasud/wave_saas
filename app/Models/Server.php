<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Server extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'product_id',
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

    protected $table = 'servers';


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

    public function isVerified(): bool {
        return $this->verified_at !== null;
    }

    public function isProvisioned(): bool {
        return $this->provisioned_at !== null;
    }

    public function instance(): HasOne {
        return $this->hasOne(Instance::class);
    }

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

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function verify()
    {
        $this->verified_at = now();
        $this->verified_by = Auth::id();
        $this->save(); 
    }

    public function provisioned()
    {
        $this->provisioned_at = now();
        $this->save();
    }

}
