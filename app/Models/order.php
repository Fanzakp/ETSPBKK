<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    // These fields are mass assignable
    protected $fillable = [
        'user_id',
        'total_amount',
        'shipping_address',
        'payment_method',
        'status',
    ];

    /**
     * Relationship with User (Order belongs to a User)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with OrderItem (Order has many OrderItems)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
