<?php

namespace App\Http\Controllers;

use App\Models\OrderFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('order_attachments/' . $request->order_id, $filename, 'public');

        $attachment = OrderFile::create([
            'order_id' => $request->order_id,
            'name' => $filename,
            'path' => $path,
            'note' => $request->note,
            'uploaded_by' => Auth::user()->name ?? 'Admin',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Attachment saved successfully!',
            'attachment' => $attachment
        ]);
    }

    public function list($orderId)
    {
        $attachments = OrderFile::where('order_id', $orderId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($att) {
                return [
                    'id' => $att->id,
                    'name' => $att->name,
                    'path' => $att->path,
                    'created_at' => $att->created_at->format('d/m/y'),
                ];
            });

        return response()->json($attachments);
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
        $attachment = OrderFile::findOrFail($id);

        // Delete the file from storage
        if (Storage::exists('public/' . $attachment->path)) {
            Storage::delete('public/' . $attachment->path);
        }

        // Delete the DB record
        $attachment->delete();

        return response()->json(['success' => true, 'message' => 'Attachment deleted']);
    }
}
