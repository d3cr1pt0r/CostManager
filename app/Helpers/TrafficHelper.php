<?php

use CostManager\Traffic;
use CostManager\TrafficType;

class TrafficHelper
{
    function TrafficHelper($date_from=null, $date_to=null) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function addTraffic($name, $desc, $amount, $is_cost)
    {
        $traffic_type = new TrafficType;
        $traffic_type->name = $name;
        $traffic_type->desc = $desc;
        $traffic_type->is_cost = $is_cost;
        $traffic_type->times_used = 0;
        $traffic_type->save();

        $traffic_type->times_used += 1;
        $traffic_type->save();

        $traffic = new Traffic;
        $traffic->amount = $amount;
        $traffic->trafficType()->associate($traffic_type);
        $traffic->save();
    }

    public function getTraffic($date_from=null, $date_to=null) {
        if ($date_from == null && $date_to == null)
            return Traffic::orderBy('created_at', 'desc')->get();
        return Traffic::whereRaw('DATE(created_at) >= "'.$date_from.'"')->whereRaw('DATE(created_at) <= "'.$date_to.'"')->get();
    }

    public function getBalance($date_from=null, $date_to=null) {
        if ($date_from == null && $date_to == null)
            return $this->getProfit() + $this->getExpense();
        return $this->getProfit($date_from, $date_to) + $this->getExpense($date_from, $date_to);
    }

    public function getProfit($date_from=null, $date_to=null)
    {
        $total = 0;

        if ($date_from == null && $date_to == null) {
            $traffic = Traffic::whereHas('TrafficType', function($q) {
                $q->where('is_cost', 0);
            })->get();
        }
        else {
            $traffic = Traffic::whereHas('TrafficType', function($q) {
                $q->where('is_cost', 0);
            })->whereRaw('DATE(created_at) >= "'.$date_from.'"')->whereRaw('DATE(created_at) <= "'.$date_to.'"')->get();
        }

        foreach ($traffic as $t) {
            $total += $t->amount;
        }

        return $total;
    }

    public function getExpense($date_from=null, $date_to=null)
    {
        $total = 0;

        if ($date_from == null && $date_to == null) {
            $traffic = Traffic::whereHas('TrafficType', function($q) {
                $q->where('is_cost', 1);
            })->get();
        }
        else {
            $traffic = Traffic::whereHas('TrafficType', function($q) {
                $q->where('is_cost', 1);
            })->whereRaw('DATE(created_at) >= "'.$date_from.'"')->whereRaw('DATE(created_at) <= "'.$date_to.'"')->get();
        }

        foreach ($traffic as $t) {
            $total -= $t->amount;
        }

        return $total;
    }

    public function getChartTrafficData() {
        $chart_data = [];

        $balance = 0;
        foreach($traffic as $t) {
            $date = date("d/m/Y", strtotime($t->created_at));
            $amount = $t->amount;
            $balance += $amount;

            $chart_data[] = ["x" => $date, "y" => $balance];
        }

        return Response::json(array('chart_data' => json_encode($chart_data)));
        return $chart_data;
    }
}