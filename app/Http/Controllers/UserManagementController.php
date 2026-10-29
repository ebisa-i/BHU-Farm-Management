<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private const ROLES = [
        'System Administrator',
        'Team Leader',
        'Vocational Worker',
        'Student/Researcher',
        'University Management',
    ];

    private const STATUSES = ['Active', 'Inactive'];

    public function index(): View
    {
        $users = User::latest()->paginate(15);
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'Active')->count();

        return view('user-management.index', compact('users', 'totalUsers', 'activeUsers'));
    }

    public function create(): View
    {
        return view('user-management.create', ['roles' => self::ROLES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(self::ROLES)],
            'status' => ['required', Rule::in(self::STATUSES)],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('user-management.index')
            ->with('success', 'User created successfully.');
    }

    public function show(User $userManagement): View
    {
        return view('user-management.edit', [
            'user' => $userManagement,
            'roles' => self::ROLES,
        ]);
    }

    public function edit(User $userManagement): View
    {
        return view('user-management.edit', [
            'user' => $userManagement,
            'roles' => self::ROLES,
        ]);
    }

    public function update(Request $request, User $userManagement): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userManagement->id)],
            'role' => ['required', Rule::in(self::ROLES)],
            'status' => ['required', Rule::in(self::STATUSES)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (! empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $userManagement->update($data);

        return redirect()
            ->route('user-management.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(Request $request, User $userManagement): RedirectResponse
    {
        if ($userManagement->id === $request->user()->id) {
            return redirect()
                ->route('user-management.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $userManagement->delete();

        return redirect()
            ->route('user-management.index')
            ->with('success', 'User deleted successfully.');
    }
}
