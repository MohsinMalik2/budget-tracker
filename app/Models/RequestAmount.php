<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestAmount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'amount', 'reason', 'status',
    ];

    /**
     * Get the user that owns the request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
