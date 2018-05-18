<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $fillable = [
        "id", "parent_id", "name",
        "fullname", "lat", "lng",
        "level",
    ];

    /**
     * 三级行政划分树
     */
    public function tree3() {
        $tree = $this->provinces();
        foreach ($tree as $p) {
            $p->cities = $p->children();
            foreach ($p->cities as $c) {
                $c->districts = $c->children();
            }
        }
        return $tree;
    }

    public function parent()
    {
        return $this->parent_id?
            $this->find($this->parent_id):
            null;
    }

    public function children()
    {
        return $this->where("parent_id", "=", $this->id)
            ->get();
    }

    public function provinces()
    {
        return $this->where("level", "=", 1)->get();
    }

    public function cities()
    {
        return $this->where("level", "=", 2)->get();
    }

    public function districts()
    {
        return $this->where("level", "=", 3)->get();
    }
}