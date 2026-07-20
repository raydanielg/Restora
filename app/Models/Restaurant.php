<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'type', 'description', 'logo', 'cover_image',
        'phone', 'email', 'address', 'location', 'currency', 'tax_rate',
        'service_charge', 'opening_hours', 'payment_methods', 'status',
        'kyc_documents', 'tin_number',
    ];

    protected function casts(): array
    {
        return [
            'opening_hours' => 'array',
            'payment_methods' => 'array',
            'kyc_documents' => 'array',
            'tax_rate' => 'decimal:2',
            'service_charge' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function menuItems()
    {
        return $this->hasMany(MenuItem::class);
    }

    public function tables()
    {
        return $this->hasMany(RestaurantTable::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
