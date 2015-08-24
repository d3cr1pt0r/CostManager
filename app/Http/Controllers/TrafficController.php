<?php

namespace CostManager\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Symfony\Component\CssSelector\Node\CombinedSelectorNode;
use TrafficHelper;
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

    public function getChart() {
        $view = view('chart');
        return $view;
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

        $traffic_helper = new TrafficHelper;
        $traffic_helper->addTraffic($name, $desc, $amount, 0);

        return redirect('/');
    }

    public function postAddExpense()
    {
        $name = Input::get('name');
        $desc = Input::get('desc');
        $amount = Input::get('amount');

        if (!is_numeric($amount))
            return redirect('/')->with('message', 'Wrong € amount format!');

        $traffic_helper = new TrafficHelper;
        $traffic_helper->addTraffic($name, $desc, $amount, 1);

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

        $traffic_type = TrafficType::find($traffic->trafficType->id);
        $traffic->delete();
        $traffic_type->delete();

        return redirect('/');
    }

    //////////////////////
    // HELPER FUNCTIONS //
    // MOVE AWAY ASAP!! //
    //////////////////////

    private function getTrafficData($date_from=null, $date_to=null)
    {
        $traffic_helper = new TrafficHelper($date_from, $date_to);

        $view = view('welcome');
        $view->traffic = $traffic_helper->getTraffic($date_from, $date_to);
        $view->balance = $traffic_helper->getBalance($date_from, $date_to);
        $view->profit_traffic_types = TrafficType::where('is_cost', 0)->orderBy('times_used', 'desc')->take(5)->get();
        $view->expense_traffic_types = TrafficType::where('is_cost', 1)->orderBy('times_used', 'desc')->take(5)->get();
        $view->chart_data = $this->getChartTrafficData($view->traffic);

        return $view;
    }

    private function getChartTrafficData($traffic) {
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
