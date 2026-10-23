<?php

namespace App\Http\Controllers;

use App\Models\StaffActivity;

class StaffActivityController extends Controller
{
    public function index()
    {
        $activities = StaffActivity::latest()->paginate(15);

        return view('staff-activities.index', compact('activities'));
    }
}