<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    use HasFactory;

    protected   $fillable = [
        'customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_type'
    ];

}
