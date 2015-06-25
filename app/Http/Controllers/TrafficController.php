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
        $traffic = Traffic::all();
        $traffic_types = TrafficType::all();

        $view = view('welcome');
        $view->traffic = $traffic;
        $view->traffic_types = $traffic_types;

        return $view;
    }

    public function postAddProfit()
    {
        $name = Input::get('name');
        $amount = Input::get('amount');

        $traffic_types = TrafficType::all();
        $traffic_type = null;

        foreach ($traffic_types as $tt) {
            if ($tt->name == $name) {
                $traffic_type = $tt;
                break;
            }
        }

        if ($traffic_type == null) {
            $traffic_type = new TrafficType;
            $traffic_type->name = $name;
            $traffic_type->desc = 'No desc';
            $traffic_type->is_cost = 0;
            $traffic_type->save();
        }

        $traffic = new Traffic;
        $traffic->amount = $amount;
        $traffic->type()->save($traffic_type);
        $traffic->save();

        return redirect('/')->with('message', 'Stuff happened!');
    }

    public function postAddExpense()
    {
        return redirect('/');//->with('message', 'postAddExpense');
    }
}
