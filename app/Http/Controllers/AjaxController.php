<?php

namespace CostManager\Http\Controllers;

use Illuminate\Http\Request;

use CostManager\Http\Requests;
use CostManager\Http\Controllers\Controller;
use CostManager\TrafficType;

class AjaxController extends Controller
{
    public function getIndex()
    {
        return "getIndex";
    }

    public function getTrafficTypes()
    {
        $traffic_types = TrafficType::all();
        $data = [];

        foreach ($traffic_types as $tt) {
            $data[] = $tt->name;
        }

        return json_encode($data);
    }
}
