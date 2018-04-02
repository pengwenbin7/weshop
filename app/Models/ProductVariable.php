<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariable extends Model
{
    protected $fillable = ["product_id", "stock"];
}
