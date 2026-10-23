<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);

        $totalUsers = User::count();

        return view('user-management.index', compact(
            'users',
            'totalUsers'
        ));
    }
}
