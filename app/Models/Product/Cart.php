<?php

namespace App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = "carts";

    protected $fillable = [
        'prod_id', 'name', 'image', 'description', 'price', 'user_id',
    ];
}
