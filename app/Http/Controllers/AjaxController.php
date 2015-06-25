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

    public function getTrafficTypesProfit()
    {
        $traffic_types = TrafficType::where('is_cost', 0)->get();
        $data = [];

        foreach ($traffic_types as $tt) {
            $data[] = $tt->name;
        }

        return json_encode($data);
    }

    public function getTrafficTypesExpense()
    {
        $traffic_types = TrafficType::where('is_cost', 1)->get();
        $data = [];

        foreach ($traffic_types as $tt) {
            $data[] = $tt->name;
        }

        return json_encode($data);
    }
}
