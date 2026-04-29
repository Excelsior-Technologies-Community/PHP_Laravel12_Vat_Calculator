<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VatHistory extends Model
{
    protected $fillable = [
        'net_price',
        'country_code',
        'vat_rate',
        'vat_amount',
        'gross_price'
    ];
}