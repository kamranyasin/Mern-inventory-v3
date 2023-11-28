<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
      'name', 'quantity', 'paid_amount', 'due_amount', 'total_amount'
    ];

}
