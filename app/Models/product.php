<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @OA\Schema(
 *     schema="Product",
 *     required={"name", "description", "price", "stock"},
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="name", type="string", maxLength=255, example="T-Shirt DIS MEDIA"),
 *     @OA\Property(property="description", type="string", example="Comfortable cotton t-shirt with DIS MEDIA logo"),
 *     @OA\Property(property="price", type="number", format="float", example=150000),
 *     @OA\Property(property="stock", type="integer", example=100),
 *     @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *     @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 * )
 */

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'stock', 'image_url', 'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }
}   