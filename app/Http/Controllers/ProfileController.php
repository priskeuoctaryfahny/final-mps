<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Stevebauman\Location\Facades\Location;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    use LogsActivity;
    /**
     * Display the user's profile form.
     */
    public function index(Request $request): View
    {
        $location = Location::get(request()->ip());
        return view('dashboard.profile.index', [
            'user' => $request->user(),
            'title' => 'Edit Profile',
            'activity' => $request->user()->activities()->latest()->get(),
            'location' => $location,
        ]);
    }

    public function edit(Request $request): View
    {
        $location = Location::get(request()->ip());
        return view('dashboard.profile.index', [
            'user' => $request->user(),
            'title' => 'Edit Profile',
            'activity' => $request->user()->activities()->latest()->get(),
            'location' => $location,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'picture' => ['nullable', 'image', 'max:2048'], // 2MB Max
            'gender' => 'required|in:Male,Female',
            'date_of_birth' => 'required|date',
        ]);

        $user = $request->user();
        $user->fill($request->only(['name', 'email', 'gender', 'date_of_birth', 'whatsapp']));

        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('profile-photos', 'public');

            if ($user->picture) {
                Storage::disk('public')->delete($user->picture);
            }

            $user->picture = $path;
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Update password only if provided
        if ($request->filled('password')) {
            $request->validate([
                'current_password' => ['required_with:password', 'current_password'], // Only required if 'password' is present
                'password' => ['nullable', 'confirmed', Password::defaults()], // 'nullable' allows optional password update
            ]);
            $user->password = Hash::make($request->password);
            $description = 'Edit password';
            $this->logActivity('edit_password', $request->user(), null, $description);
        } else {
            $description = 'Edit profil';
            $this->logActivity('edit_profile', $request->user(), null, $description);
        }

        $user->save();

        return Redirect::route('profiles.index')->with('success', 'Profile updated successfully.');
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
