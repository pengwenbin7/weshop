<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    protected $fillable = [
        "user_id", "product_id", "keyword",
        "action",
    ];

    public function hotSearch($limit = 10)
    {
        $hot = $this->selectRaw("keyword, COUNT(keyword) AS ck")
             ->where("action", "=", "search")
             ->groupBy("keyword")
             ->orderBy("ck", "desc")
             ->limit($limit)
             ->get();
        return $hot;
    }
}
