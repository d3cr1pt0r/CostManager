<?php

namespace CostManager\Http\Controllers;

use Illuminate\Http\Request;

use CostManager\Http\Requests;
use CostManager\Http\Controllers\Controller;
use CostManager\TrafficType;
use CostManager\Traffic;

use Input;
use DateTime;
use TrafficHelper;

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

    public function getChartTrafficData() {
        $traffic_helper = new TrafficHelper;
        $traffic = $traffic_helper->getTraffic();
        $chart_data_map = [];
        $chart_data = [];

        $balance = 0;
        foreach($traffic as $t) {
            $date = date("Y-m-d", strtotime($t->created_at));
            $amount = $t->amount;
            if ($t->trafficType->is_cost)
                $balance -= $amount;
            else
                $balance += $amount;

            $from = DateTime::createFromFormat('Y-m-d', $date)->format('Y-m-d');
            $to = DateTime::createFromFormat('Y-m-d', $date)->format('Y-m-d');

            $chart_data_map[$date] = ["x" => $date, "y" => $traffic_helper->getBalance(null, $to)];
        }
        foreach($chart_data_map as $cdm) {
            $chart_data[] = $cdm;
        }

        return json_encode($chart_data);
    }

    public function postUpdateTraffic() {
        $id = Input::get('traffic_id');
        $name = Input::get('traffic_name');
        $desc = Input::get('traffic_desc');
        $amt = Input::get('traffic_amt');

        $traffic_type = TrafficType::find($id);
        $traffic_type->name = $name;
        $traffic_type->desc = $desc;
        $traffic_type->save();

        $traffic = Traffic::find($traffic_type->traffic->id);
        $traffic->amount = $amt;
        $traffic->save();

        return "OK";
    }
}
