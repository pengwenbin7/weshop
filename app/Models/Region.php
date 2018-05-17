<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public function tree() {
        $tree = $this->where("level", "=", 1)->get();
        foreach ($tree as $p) {
            $p->cities = $this->where("level", "=", 2)
                      ->where("parent_id", "=", $p->id)
                      ->get();
            foreach ($p->cities as $c) {
                $c->districts = $this->where("level", "=", 3)
                             ->where("parent_id", "=", $c->id)
                             ->get();
            }
        }

        return $tree;
    }
}