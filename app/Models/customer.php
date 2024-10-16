<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'email', 'order_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function latestOrder()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }
}