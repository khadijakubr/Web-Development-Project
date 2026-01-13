<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(10)
        ]);
    }

    public function show(User $user)
    {
        return view('admin.users.show', [
            'user' => $user
        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user'
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return back()->with('success', 'User role has been updated successfully');
    }

    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return back()->with('success', 'User has been deleted successfully');
    }
}

