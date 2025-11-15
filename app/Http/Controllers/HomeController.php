<?php

namespace App\Http\Controllers;

use App\Models\Buylist;
use App\Models\Lead;
use App\Models\LineItem;
use App\Models\Notification;
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

        $last14Days = collect();
        $start = Carbon::now()->subDays(13);

        $data = [
            'today' => [
                'leads' => Lead::whereDate('created_at', $today)->count(),

                'buy' => LineItem::where('is_buylist', 1)
                    ->whereNotNull('buylist_id')
                    ->whereDate('created_at', $today)
                    ->sum('sku_total'),

                'ordered' => Order::whereDate('created_at', $today)->sum('total'),

                'shipped' => Shipping::whereDate('created_at', $today)->count(),
                'date' => $today->format('Y-m-d'),
            ],

            'this_week' => [
                'leads' => Lead::whereBetween('created_at', [$startWeek, $endWeek])->count(),

                'buy' => LineItem::where('is_buylist', 1)
                    ->whereNotNull('buylist_id')
                    ->whereBetween('created_at', [$startWeek, $endWeek])
                    ->sum('sku_total'),

                'ordered' => Order::whereBetween('created_at', [$startWeek, $endWeek])->sum('total'),

                'shipped' => Shipping::whereBetween('created_at', [$startWeek, $endWeek])->count(),
                'start' => $startWeek->format('Y-m-d'),
                'end' => $endWeek->format('Y-m-d'),
            ],

            'last_week' => [
                'leads' => Lead::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),

                'buy' => LineItem::where('is_buylist', 1)
                    ->whereNotNull('buylist_id')
                    ->whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])
                    ->sum('sku_total'),

                'ordered' => Order::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->sum('total'),

                'shipped' => Shipping::whereBetween('created_at', [$lastWeekStart, $lastWeekEnd])->count(),
                'start' => $lastWeekStart->format('Y-m-d'),
                'end' => $lastWeekEnd->format('Y-m-d'),
            ],

            'last30' => [
                'leads' => Lead::where('created_at', '>=', $last30)->count(),

                'buy' => LineItem::where('is_buylist', 1)
                    ->whereNotNull('buylist_id')
                    ->where('created_at', '>=', $last30)
                    ->sum('sku_total'),

                'ordered' => Order::where('created_at', '>=', $last30)->sum('total'),

                'shipped' => Shipping::where('created_at', '>=', $last30)->count(),
                'start' => $last30->format('Y-m-d'),
                'end' => Carbon::now()->format('Y-m-d'),
            ],
        ];

        // ---------------------------
        // 14 DAYS GRAPH DATA
        // ---------------------------

        for ($i = 0; $i < 14; $i++) {
            $date = $start->copy()->addDays($i)->format('Y-m-d');

            $last14Days->push([
                'date' => $date,

                'leads' => Lead::whereDate('created_at', $date)->count(),

                // SAME AS BOXES (sku_total)
                'buy' => LineItem::where('is_buylist', 1)
                    ->whereNotNull('buylist_id')
                    ->whereDate('created_at', $date)
                    ->sum('sku_total'),

                // Ordered from ORDERS table
                'ordered' => Order::whereDate('created_at', $date)->sum('total'),

                'shipped' => Shipping::whereDate('created_at', $date)->count(),
            ]);
        }

        $data['last14'] = $last14Days;

        return view('home', compact('data'));
    }

    public function list()
    {
        $notifications = Notification::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return response()->json($notifications);
    }

    public function markRead($id)
    {
        $notif = Notification::find($id);
        if ($notif) {
            $notif->update(['read_at' => now()]);
        }

        return response()->json(['success' => true]);
    }

    public function download($file)
    {
        $path = storage_path('app/reports/' . $file);

        if (!file_exists($path)) {
            abort(404, 'File not found.');
        }

        return response()->download($path);
    }

}
