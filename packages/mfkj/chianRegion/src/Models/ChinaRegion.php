<?php

namespace Mfkj\ChianRegion\Models;

use Illuminate\Database\Eloquent\Model;
use Mfkj\ChianRegion\Models\ChinaRegionVersion as Version;

class ChinaRegion extends Model
{
    public function version()
    {
        return Version::orderBy("created_at", "desc")
            ->first();
    }
}
