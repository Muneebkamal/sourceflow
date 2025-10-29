<?php

namespace App\Http\Controllers;

use App\Models\Buylist;
use App\Models\Lead;
use App\Models\Order;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $today = Carbon::today();
        $startWeek = Carbon::now()->startOfWeek();
        $endWeek = Carbon::now()->endOfWeek();
        $lastWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $lastWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $last30 = Carbon::now()->subDays(30);

        $data = [
            'today' => [
                'leads' => Lead::whereDate('created_at', $today)->count(),
                'buy' => Buylist::whereDate('created_at', $today)->count(),
                'ordered' => Order::whereDate('created_at', $today)->count(),
                'shipped' => Shipping::whereDate('created_at', $today)->count(),
                'date' => $today->format('Y-m-d'),
            ],
            'this_week' => [
                'leads' => Lead::whereBetween('created_at', [$startWeek, $endWeek])->count(),
                'buy' => Buylist::whereBetween('created_at', [$startWeek, $endWeek])->count(),
                'ordered' => Order::whereBetween('created_at', [$startWeek, $endWeek])->count(),
                'shipped' => Shipping::whereBetween('created_at', [$startWeek, $endWeek])->count(),
                'start' => $startWeek->format('Y-m-d'),
                'end' => $endWeek->format('Y-m-d'),
            ],
            'last_week' => [
                'leads' => Lead::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
                'buy' => Buylist::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
                'ordered' => Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
                'shipped' => Shipping::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
                'start' => $lastWeekStart->format('Y-m-d'),
                'end' => $lastWeekEnd->format('Y-m-d'),
            ],
            'last30' => [
                'leads' => Lead::where('created_at', '>=', $last30)->count(),
                'buy' => Buylist::where('created_at', '>=', $last30)->count(),
                'ordered' => Order::where('created_at', '>=', $last30)->count(),
                'shipped' => Shipping::where('created_at', '>=', $last30)->count(),
                'start' => $last30->format('Y-m-d'),
                'end' => Carbon::now()->format('Y-m-d'),
            ],
        ];

        return view('home', compact('data'));
    }
}
