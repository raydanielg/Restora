<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'restaurant_id', 'table_id', 'waiter_id',
        'customer_name', 'customer_phone', 'status', 'order_type',
        'subtotal', 'tax_amount', 'service_charge', 'discount', 'total',
        'notes', 'accepted_at', 'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'service_charge' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'accepted_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function table()
    {
        return $this->belongsTo(RestaurantTable::class, 'table_id');
    }

    public function waiter()
    {
        return $this->belongsTo(User::class, 'waiter_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'ORD-' . str_pad((string) static::max('id') + 1, 6, '0', STR_PAD_LEFT);
    }
}
