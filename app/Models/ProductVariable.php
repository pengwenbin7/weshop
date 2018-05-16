<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariable extends Model
{
    protected $fillable = ["product_id", "unit_price", "stock"];

    public function product()
    {
        return $this->belongsTo("App\Models\Prodcut");
    }
}
