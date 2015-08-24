<?php

namespace CostManager;

use Illuminate\Database\Eloquent\Model;

class TrafficType extends Model
{
    protected $table = 'traffic_type';

    public function traffic()
    {
        return $this->hasOne('CostManager\Traffic');
    }

}
