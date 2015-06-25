<?php

namespace CostManager;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    protected $table = 'traffic';

    public function trafficType()
    {
        return $this->belongsTo('CostManager\TrafficType', 'traffic_type_id');
    }
}
