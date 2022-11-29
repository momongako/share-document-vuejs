<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel query()
 * @mixin \Eloquent
 */
class BaseModel extends Model
{
    public function getCreatedAtAttribute($value){
        if ($value) {
            $date = Carbon::parse($value);
            return $date->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute($value){
        if ($value) {
            $date = Carbon::parse($value);
            return $date->format('Y-m-d H:i:s');
        }
    }
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected static function boot()
    {
        parent::boot();
    }
}
