<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'grand_total',
        'payment_method',
        'payment_status',
        'status',
        'currency',
        'shipping_amount',
        'shipping_method',
        'notes',
    ];

    public function user():BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function address():HasOne {
        return $this->hasOne(Address::class);
    }

    public function orderitems():HasMany {
        return $this->hasMany(OrderItem::class);
    }

    public function recalculateTotal(): void
    {
        $this->shipping_amount = 0;
        $this->grand_total = $this->orderitems->sum(function (OrderItem $item) {
            if (!empty($this->shipping_method)) {
                $this->shipping_amount = $this->shipping_amount + $item->quantity;
            }
            return $item->quantity * $item->unit_amount;
        });
        $this->save(); // Guarda las modificaciones realizadas en el order.
    }

/*     protected static function booted()
    {
        static::created(function (Order $order) {
            $order->recalculateTotal();
        });

        static::updated(function (Order $order) {
            $order->recalculateTotal();
        });
    } */
}
