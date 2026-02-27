<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = \App\Models\Activity::with('user')->latest()->paginate(15);
        return view('activities.index', compact('activities'));
    }

    public function markAsRead(Request $request)
    {
        \App\Models\Activity::where('is_read', false)->update(['is_read' => true]);
        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca.');
    }
}
