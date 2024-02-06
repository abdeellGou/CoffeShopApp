<?php

namespace App\Models\product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookedtables extends Model
{
    use HasFactory;

    protected $table = "bookedtables";

    protected $fillable = [
        'first_name', 'last_name', 'bookdate', 'time', 'phone', 'message', 'user_id',
    ];
}
