<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    protected $fillable = [
    'user_id', 'status', 'total', 'shipping_name', 'shipping_phone', 'shipping_address', 'notes'
    ];


    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id')
                    ->withPivot('quantity', 'price');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
