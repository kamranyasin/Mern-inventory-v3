<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable =[
      'labour_name',
      'salary',
      'bonus',
      'total',
      'issue_date'
  ];
}
