<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shipping.index');
    }

    public function getData(Request $request)
    {
        $query = Shipping::select(['id', 'name', 'status', 'date', 'market_place', 'items', 'tracking_number', 'notes']);

        // 🔹 Apply search filter
        if ($request->filled('search_value')) {
            $search = $request->search_value;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('market_place', 'like', "%{$search}%")
                ->orWhere('tracking_number', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        // 🔹 Apply status filter
        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // 🔹 Apply date range filter
        if ($request->filled('dateRange')) {
            [$start, $end] = explode(' - ', $request->dateRange);
            $startDate = Carbon::createFromFormat('m/d/Y', trim($start))->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', trim($end))->endOfDay();
            $query->whereBetween('date', [$startDate, $endDate]);
        }

        return DataTables::of($query)
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="form-check-input row-checkbox" value="' . $row->id . '">';
            })
            ->editColumn('status', function ($row) {
                $statuses = [
                    'open' => 'Open',
                    'in_transit' => 'In Transit',
                    'closed' => 'Closed'
                ];

                $html = '<select class="form-select form-select-sm shipping-status" data-id="'.$row->id.'">';
                foreach ($statuses as $key => $label) {
                    $selected = ($row->status === $key) ? 'selected' : '';
                    $html .= '<option class="bg-white text-black" value="'.$key.'" '.$selected.'>'.$label.'</option>';
                }
                $html .= '</select>';

                return $html;
            })
            ->addColumn('actions', function ($row) {
                $url = route('shipping.show', $row->id);
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="'.$url.'" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" data-bs-toggle="dropdown" data-bs-container="body">
                                <i class="ti ti-dots-vertical"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>';
            })
            ->rawColumns(['checkbox', 'status', 'actions'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shipping = Shipping::where('id', $id)->first();
        return view('shipping.show', compact('shipping'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
