<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Labour extends Model
{
    use HasFactory;

    protected $fillable = [
      'first_name',
      'last_name',
      'idn_number',
      'phone',
      'age',
      'address',
      'city',
      'work_type',
      'join_date',
      'salary'
  ];
}
