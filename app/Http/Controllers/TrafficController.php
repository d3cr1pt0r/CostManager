<?php

namespace CostManager\Http\Controllers;

use Input;

use CostManager\Http\Requests;
use CostManager\Http\Controllers\Controller;

use CostManager\Traffic;
use CostManager\TrafficType;

class TrafficController extends Controller
{
    public function getIndex()
    {
        $traffic = Traffic::orderBy('created_at', 'desc')->get();
        $traffic_types = TrafficType::all();

        $view = view('welcome');
        $view->traffic = $traffic;
        $view->traffic_types = $traffic_types;
        $view->balance = $this->getProfit() + $this->getExpense();

        return $view;
    }

    public function postAddProfit()
    {
        $name = Input::get('name');
        $amount = Input::get('amount');

        $this->addTraffic($name, $amount, 0);

        return redirect('/');
    }

    public function postAddExpense()
    {
        $name = Input::get('name');
        $amount = Input::get('amount');

        $this->addTraffic($name, $amount, 1);

        return redirect('/');
    }

    public function getRemoveTraffic($id)
    {
        $traffic = Traffic::find($id);

        if ($traffic == null)
            return redirect('/')->with('message', 'Model not found!');

        $traffic->delete();

        return redirect('/');
    }

    //////////////////////
    // HELPER FUNCTIONS //
    // MOVE AWAY ASAP!! //
    //////////////////////

    private function addTraffic($name, $amount, $is_cost)
    {
        $name = Input::get('name');
        $amount = Input::get('amount');

        $traffic_type = TrafficType::where('name', $name)->first();
        
        if ($traffic_type == null) {
            $traffic_type = new TrafficType;
            $traffic_type->name = $name;
            $traffic_type->desc = 'No desc';
            $traffic_type->is_cost = $is_cost;
            $traffic_type->save();
        }

        $traffic = new Traffic;
        $traffic->amount = $amount;
        $traffic->trafficType()->associate($traffic_type);
        $traffic->save();
    }

    private function getProfit($date_from=null, $date_to=null)
    {
        $total = 0;

        $traffic = Traffic::whereHas('TrafficType', function($q) {
            $q->where('is_cost', 0);
        })->get();

        foreach ($traffic as $t) {
            $total += $t->amount;
        }

        return $total;
    }

    private function getExpense($date_from=null, $date_to=null)
    {
        $total = 0;

        $traffic = Traffic::whereHas('TrafficType', function($q) {
            $q->where('is_cost', 1);
        })->get();

        foreach ($traffic as $t) {
            $total -= $t->amount;
        }

        return $total;
    }
}
