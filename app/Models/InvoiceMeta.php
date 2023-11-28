<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceMeta extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'category_id',
        'product_id',
        'quantity',
        'unit_price',
        'unit_id',
    ];

    public function category(){

        return $this->belongsTo('App\Models\Category');

    }

    public function product(){

        return $this->belongsTo('App\Models\Product');

    }

    public function unit(){

        return $this->belongsTo('App\Models\Units');

    }

}
