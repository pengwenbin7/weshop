<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * 系统设置类
 * 实现了便捷的增(add)、删(remove)、改(set)、查(get, keys, has)方法
 */
class Config extends Model
{
    protected $fillable = [
        "key", "value", "note",
    ];

    public static function get(string $key, $default = null)
    {
        $fetch = static::where("key", "=", $key)->get();
        return $fetch->isEmpty()?
            $default:
            $fetch->first()->value;
    }

    public static function keys()
    {
        $collect = static::select("key")->distinct()->get();
        $ks = [];
        $collect->each(function ($k) use(&$ks) {
            $ks[] = $k->key;
        });
        return $ks;
    }

    public static function has(string $key)
    {
        return static::where("key", "=", $key)->get()->isNotEmpty();
    }

    public static function add($key, $value, $note)
    {
        return static::firstOrCreate([
            "key" => $key,
            "value" => $value,
            "note" => $note,
        ]);
    }

    public static function set($key, $value, $note = null)
    {
        if (!static::has($key)) {
            return 0;
        }
        
        $k = static::where("key", "=", $key)->get()->first();
        $k->value = $value;
        if ($note) {
            $k->note = $note;
        }
        return $k->save();
    }

    public static function remove($key)
    {
        return static::where("key", "=", $key)->delete();
    }
}
