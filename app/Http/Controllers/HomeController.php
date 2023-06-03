<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $events = User::count();
        $orders_count = Order::count();

        $date=[];
        $users=[];
        $orders=[];
        for ($i = 0; $i < 7; $i++){
            $range = \Carbon\Carbon::now()->subDays($i)->format('20y-m-d');
            $user = User::whereDate('created_at',$range)->get();
            $order = Order::whereDate('created_at',$range)->orderBy('id', 'DESC')->get();
            $date[]=$range;
            $users[]=$user->count();
            $orders[]=$order->count();
        }
        return view('dashboard.dashboard',compact('events','orders_count','date','users','orders'));
    }
}
