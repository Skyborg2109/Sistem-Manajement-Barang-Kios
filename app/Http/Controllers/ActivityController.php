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

    public function markAsRead()
    {
        \App\Models\Activity::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }
}
