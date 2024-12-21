<?php

namespace App\Models\Dashboard;

use App\Models\User;
use App\Models\Dashboard\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'stock',
    ];

    /**
     * Get the transactions for the gas.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the user that owns the gas.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
