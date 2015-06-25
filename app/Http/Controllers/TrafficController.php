<?php

namespace CostManager\Http\Controllers;

use Illuminate\Http\Request;

use CostManager\Http\Requests;
use CostManager\Http\Controllers\Controller;

class TrafficController extends Controller
{
    public function getIndex()
    {
        $view = view('welcome');
        return $view;
    }

    public function postAddProfit()
    {
        return redirect('/')->with('message', 'postAddProfit');
    }

    public function postAddExpense()
    {
        return redirect('/')->with('message', 'postAddExpense');
    }

}
