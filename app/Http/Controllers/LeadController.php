<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Source;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sources = Source::all();
        $templates = Template::all();
        return view('leads.index', compact('sources', 'templates'));
    }

    public function getData(Request $request)
    {
        $leads = Lead::query();

        if ($request->has('source_id') && $request->source_id) {
            $leads->where('source_id', $request->source_id);
        }

        if ($request->has('search_text') && $request->search_text) {
            $search = $request->search_text;
            $leads->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('asin', 'like', "%{$search}%")
                ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        return DataTables::of($leads)
            ->editColumn('name', function ($lead) {
                $fullName = e($lead->name);
                return "<div class='text-truncate-multiline' data-bs-toggle='tooltip' title='{$fullName}'>{$fullName}</div>";
            })
            ->editColumn('date', fn($lead) => Carbon::parse($lead->date)->format('m/d/y'))
            ->editColumn('cost', fn($b) => '$' . number_format((float)$b->cost, 2))
            ->editColumn('sell_price', fn($lead) => '$' . number_format((float)$lead->sell_price, 2))
            ->editColumn('net_profit', fn($lead) => '$' . number_format((float)$lead->net_profit, 2))
            ->editColumn('created_at', fn($lead) => Carbon::parse($lead->created_at)->format('m/d/y'))
            ->editColumn('updated_at', fn($lead) => Carbon::parse($lead->updated_at)->format('m/d/y'))
            ->addColumn('actions', function ($row) {
                return '
                    <div class="d-flex justify-content-center gap-1">
                        <a href="#" class="btn btn-sm btn-light"><i class="ti ti-eye"></i></a>
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
            ->rawColumns(['name', 'actions'])
            ->make(true);
    }

    public function details($id)
    {
        $template = Template::findOrFail($id);

        // Decode the JSON column
        $mapping = json_decode($template->mapping_template, true);

        // Convert JSON to array of key-value pairs
        $details = [];
        foreach ($mapping as $column => $value) {
            $details[] = [
                'column' => $column,
                'value' => $value ?? '—'
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $details
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
