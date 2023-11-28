<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =[
      'payment_to_from',
      'type',
      'using',
      'amount',
      'status',
      'transaction_date_time'
    ];
}
