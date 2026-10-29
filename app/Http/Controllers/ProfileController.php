<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->safe()->except('profile_photo'));

        // Handle photo upload — store directly in public/profile-photos/
        if ($request->hasFile('profile_photo')) {
            // Delete the old file first
            if ($user->profile_photo) {
                $oldPath = public_path($user->profile_photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);ph
                }
                // Clear the old value so save() detects a real change
                $user->profile_photo = null;
            }

            $file = $request->file('profile_photo');
            // Always unique: user ID + random UUID + timestamp
            $filename = 'profile-photos/'
                .$user->id.'_'
                .Str::uuid()
                .'.'.strtolower($file->getClientOriginalExtension());

            $file->move(public_path('profile-photos'), basename($filename));
            $user->profile_photo = $filename;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('dashboard')->with('profile_success', 'Profile updated successfully. Your photo is now showing across the system.');
    }

    /**
     * Delete the user's profile photo.
     */
    public function destroyPhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            $path = public_path($user->profile_photo);
            if (file_exists($path)) {
                unlink($path);
            }
            $user->profile_photo = null;
            $user->save();
        }

        return Redirect::route('profile.edit')->with('status', 'photo-removed');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
