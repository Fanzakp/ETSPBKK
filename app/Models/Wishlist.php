<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product associated with the wishlist item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the total price of the wishlist item.
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->quantity * $this->product->price;
    }

    /**
     * Increment the quantity of the wishlist item.
     *
     * @param int $amount
     * @return bool
     */
    public function incrementQuantity($amount = 1)
    {
        $this->quantity += $amount;
        return $this->save();
    }

    /**
     * Decrement the quantity of the wishlist item.
     *
     * @param int $amount
     * @return bool
     */
    public function decrementQuantity($amount = 1)
    {
        $this->quantity = max(1, $this->quantity - $amount);
        return $this->save();
    }

    /**
     * Check if the wishlist item belongs to a given user.
     *
     * @param User $user
     * @return bool
     */
    public function belongsToUser(User $user)
    {
        return $this->user_id === $user->id;
    }
}