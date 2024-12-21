<?php

namespace App\Models\Dashboard;

use App\Models\User;
use App\Models\Dashboard\Gas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'gas_id',
        'user_id',
        'qty',
        'amount',
        'optional_amount',
        'total_amount',
        'description',
        'reference',
        'transaction_date',
        'attachment',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        // Automatically calculate total_amount before creating or updating
        static::creating(function ($transaction) {
            $transaction->total_amount = $transaction->amount + ($transaction->optional_amount ?? 0);
            $transaction->updateGasTotal();
            if (auth()->check()) {
                $transaction->created_by = auth()->id();
                $transaction->updated_by = auth()->id();
            }
        });

        static::updating(function ($transaction) {
            // Calculate total_amount
            $transaction->total_amount = $transaction->amount + ($transaction->optional_amount ?? 0);
            $transaction->updateGasTotal();
            if (auth()->check()) {
                $transaction->updated_by = auth()->id();
            }
        });

        static::deleting(function ($transaction) {
            // When deleting, we need to revert the total in the gas table
            $gas = Gas::find($transaction->gas_id);
            if ($gas) {
                if ($transaction->type === 'in') {
                    $gas->total -= $transaction->qty;
                } else {
                    $gas->total += $transaction->qty;
                }
                $gas->save();
            }
        });
    }

    /**
     * Update the total in the gas table based on the transaction type and qty.
     */
    protected function updateGasTotal()
    {
        $gas = Gas::find($this->gas_id);
        if ($gas) {
            // Get the original transaction to determine the original quantity
            $originalTransaction = Transaction::find($this->id); // Assuming you have the transaction ID

            if ($originalTransaction) {
                // Calculate the difference in quantity
                $quantityDifference = $this->qty - $originalTransaction->qty;

                if ($this->type === 'in') {
                    $gas->total += $quantityDifference; // Add the difference
                } else {
                    $gas->total -= $quantityDifference; // Subtract the difference
                }
                $gas->save();
            } else {
                if ($this->type === 'in') {
                    $gas->total += $this->qty; // Add the difference
                } else {
                    $gas->total -= $this->qty; // Subtract the difference
                }
                $gas->save();
            }
        }
    }

    /**
     * Get the gas associated with the transaction.
     */
    public function gas()
    {
        return $this->belongsTo(Gas::class);
    }

    /**
     * Get the user that owns the transaction.
     */

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    protected function casts(): array
    {
        return [
            'transaction_date' => 'date',
            'attachment' => 'array',
        ];
    }
}
