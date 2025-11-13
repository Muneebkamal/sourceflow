<?php

namespace App\Http\Controllers;

use App\Models\Notification;
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
                return '<input type="checkbox" class="form-check-input shipping-checkbox" value="' . $row->id . '">';
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
                    $html .= '<option value="'.$key.'" '.$selected.'>'.$label.'</option>';
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
                                <li><a class="dropdown-item editShippingBtn" data-id="'.$row->id.'" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger DelSingleBtn" data-id="'.$row->id.'" href="#">Delete</a></li>
                            </ul>
                        </div>
                    </div>';
            })
            ->rawColumns(['checkbox', 'status', 'actions'])
            ->make(true);
    }

    public function export()
    {
        $shippings = Shipping::all();

        $filename = 'shipping-batch-report-' . now()->format('Y-m-d_H-i') . '-' . substr(uniqid(), -5) . '.csv';
        $path = storage_path('app/reports/' . $filename);

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }

        $file = fopen($path, 'w');

        // CSV headers
        $headers = [
            'Ship Date', 'Name', 'Status', 'Marketplace', '# Items', 'Tracking #', 'Note'
        ];
        fputcsv($file, $headers);

        foreach ($shippings as $shipping) {
            $row = [
                isset($shipping->date) ? Carbon::parse($shipping->date)->format('m/d/Y') : null,
                $shipping->name ?? null,
                $shipping->status ?? null,
                $shipping->market_place ?? null,
                $shipping->items ?? null,
                $shipping->tracking_number ?? null,
                $shipping->notes ?? null,
            ];

            fputcsv($file, $row);
        }

        fclose($file);

        // Save notification
        $notification = Notification::create([
            'title' => 'Shipping Report Ready',
            'message' => 'Your report is ready.',
            'file_url' => route('download.report', $filename),
            'file_name' => $filename,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Shipping report generated successfully!',
            'notification' => $notification
        ]);
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
        try {
            $batch = Shipping::create([
                'name' => $request->name,
                'status' => $request->status,
                'date' => $request->shipped_at,
                'tracking_number' => $request->tracking_number,
                'market_place' => $request->marketplace,
                'notes' => $request->note,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shipping batch created successfully.',
                'batch' => $batch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create shipping batch: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shipping = Shipping::where('id', $id)->first();
        return view('shipping.show', compact('shipping'));
    }

    public function showModal($id)
    {
        $batch = Shipping::find($id);
        if(!$batch) {
            return response()->json(['success' => false]);
        }
        return response()->json(['success' => true, 'batch' => $batch]);
    }

    public function updateStatus(Request $request, $id)
    {
        $batch = Shipping::findOrFail($id);
        $batch->status = $request->status;
        $batch->save();

        return response()->json(['success' => true]);
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
        try {
            $batch = Shipping::findOrFail($id);
            $batch->update([
                'name' => $request->name,
                'status' => $request->status,
                'date' => $request->shipped_at,
                'tracking_number' => $request->tracking_number,
                'market_place' => $request->marketplace,
                'notes' => $request->note,
            ]);

            return response()->json(['success' => true, 'message' => 'Shipping batch updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to update batch.']);
        }
    }

    public function bulkStatus(Request $request)
    {
        Shipping::whereIn('id', $request->ids)->update(['status' => $request->status]);
        return response()->json(['success' => true, 'message' => 'Status updated for selected records.']);
    }

    public function bulkDelete(Request $request)
    {
        Shipping::whereIn('id', $request->ids)->delete();
        return response()->json(['success' => true, 'message' => 'Selected records deleted successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $batch = Shipping::findOrFail($id);
            $batch->delete();

            return response()->json(['success' => true, 'message' => 'Shipping batch deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete batch.']);
        }
    }
}
