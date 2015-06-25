<?php

namespace CostManager;

use Illuminate\Database\Eloquent\Model;

class Traffic extends Model
{
    protected $table = 'traffic';

    public function type()
    {
        return $this->hasOne('Traffic');
    }
}
