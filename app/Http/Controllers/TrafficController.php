<?php

namespace CostManager\Http\Controllers;

use DateTime;
use Input;
use Hash;
use DB;

use CostManager\Http\Requests;
use CostManager\Http\Controllers\Controller;

use CostManager\Traffic;
use CostManager\TrafficType;

class TrafficController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.basic');
    }

    public function getIndex()
    {
        return $this->getTrafficData();
    }

    public function getWeekly()
    {
        $first_week_day = date('Y-m-d', strtotime('last monday'));
        $last_week_day = date('Y-m-d', strtotime('last monday +6 days'));

        return $this->getTrafficData($first_week_day, $last_week_day);
    }

    public function getMonthly()
    {
        $first_month_day = date('Y-m-01');
        $last_month_day = date('Y-m-'.date('t'));

        return $this->getTrafficData($first_month_day, $last_month_day);
    }

    public function getYearly()
    {
        $first_year_day = date('Y-01-01');
        $last_year_day = date('Y-01-01', strtotime('+1 year'));

        return $this->getTrafficData($first_year_day, $last_year_day);
    }

    public function postAddProfit()
    {
        $name = Input::get('name');
        $desc = Input::get('desc');
        $amount = Input::get('amount');

        if (!is_numeric($amount))
            return redirect('/')->with('message', 'Wrong € amount format!');

        $this->addTraffic($name, $desc, $amount, 0);

        return redirect('/');
    }

    public function postAddExpense()
    {
        $name = Input::get('name');
        $desc = Input::get('desc');
        $amount = Input::get('amount');

        if (!is_numeric($amount))
            return redirect('/')->with('message', 'Wrong € amount format!');

        $this->addTraffic($name, $desc, $amount, 1);

        return redirect('/');
    }

    public function postSetDateRange()
    {
        $date_start = Input::get('start');
        $date_end = Input::get('end');

        $from = DateTime::createFromFormat('d.m.Y', $date_start)->format('Y-m-d');
        $to = DateTime::createFromFormat('d.m.Y', $date_end)->format('Y-m-d');

        return $this->getTrafficData($from, $to);
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

    private function getTrafficData($date_from=null, $date_to=null)
    {
        $traffic = null;
        $view = view('welcome');

        if ($date_from == null && $date_to == null) {
            $view->traffic = Traffic::orderBy('created_at', 'desc')->get();
            $view->balance = $this->getProfit() + $this->getExpense();
        }
        else {
            $view->traffic = Traffic::whereRaw('DATE(created_at) >= "'.$date_from.'"')->whereRaw('DATE(created_at) <= "'.$date_to.'"')->get();
            $view->balance = $this->getProfit($date_from, $date_to) + $this->getExpense($date_from, $date_to);
        }
        
        $traffic_types = TrafficType::all();
        $view->profit_traffic_types = TrafficType::where('is_cost', 0)->orderBy('times_used', 'desc')->take(5)->get();
        $view->expense_traffic_types = TrafficType::where('is_cost', 1)->orderBy('times_used', 'desc')->take(5)->get();

        return $view;
    }

    private function addTraffic($name, $desc, $amount, $is_cost)
    {
        $traffic_type = TrafficType::where('name', $name)->first(); // What the fuck was I thinking? :D
        $traffic_type = null;

        if ($traffic_type == null) {
            $traffic_type = new TrafficType;
            $traffic_type->name = $name;
            $traffic_type->desc = $desc;
            $traffic_type->is_cost = $is_cost;
            $traffic_type->times_used = 0;
            $traffic_type->save();
        }

        $traffic_type->times_used += 1;
        $traffic_type->save();

        $traffic = new Traffic;
        $traffic->amount = $amount;
        $traffic->trafficType()->associate($traffic_type);
        $traffic->save();
    }

    private function getProfit($date_from=null, $date_to=null)
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
            })->whereBetween('created_at', array($date_from, $date_to))->get();
        }

        foreach ($traffic as $t) {
            $total += $t->amount;
        }

        return $total;
    }

    private function getExpense($date_from=null, $date_to=null)
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
            })->whereBetween('created_at', array($date_from, $date_to))->get();
        }

        foreach ($traffic as $t) {
            $total -= $t->amount;
        }

        return $total;
    }
}
