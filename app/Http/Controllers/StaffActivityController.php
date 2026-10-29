<?php

namespace App\Http\Controllers;

use App\Models\StaffActivity;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffActivityController extends Controller
{
    public function index()
    {
        $activities = StaffActivity::latest()->paginate(15);

        $todayCount = StaffActivity::whereDate('activity_date', today())->count();
        $completedCount = StaffActivity::where('status', 'Completed')->count();
        $totalCount = StaffActivity::count();
        $upcomingRecord = StaffActivity::where('status', 'Scheduled')
            ->whereDate('activity_date', '>=', today())
            ->orderBy('activity_date')
            ->first();

        return view('staff-activities.index', compact(
            'activities',
            'todayCount',
            'completedCount',
            'totalCount',
            'upcomingRecord'
        ));
    }

    public function create()
    {
        return view('staff-activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'assignment' => ['required', 'string', 'max:255'],
            'shift' => ['required', 'string', 'max:255'],
            'activity' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Scheduled', 'In Progress', 'Completed', 'Cancelled'])],
            'activity_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        StaffActivity::create($validated);

        return redirect()
            ->route('staff-activities.index')
            ->with('success', 'Staff activity created successfully.');
    }

    public function show(StaffActivity $staffActivity)
    {
        return view('staff-activities.show', compact('staffActivity'));
    }

    public function edit(StaffActivity $staffActivity)
    {
        return view('staff-activities.edit', compact('staffActivity'));
    }

    public function update(Request $request, StaffActivity $staffActivity)
    {
        $validated = $request->validate([
            'staff_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'assignment' => ['required', 'string', 'max:255'],
            'shift' => ['required', 'string', 'max:255'],
            'activity' => ['required', 'string', 'max:255'],
            'status' => ['required', Rule::in(['Scheduled', 'In Progress', 'Completed', 'Cancelled'])],
            'activity_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $staffActivity->update($validated);

        return redirect()
            ->route('staff-activities.index')
            ->with('success', 'Staff activity updated successfully.');
    }

    public function destroy(StaffActivity $staffActivity)
    {
        $staffActivity->delete();

        return redirect()
            ->route('staff-activities.index')
            ->with('success', 'Staff activity deleted successfully.');
    }
}
