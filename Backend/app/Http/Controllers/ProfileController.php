<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load('profile');
        return view('pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address_line_1' => 'nullable|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'alternative_phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update user data
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                $oldImagePath = public_path('uploads/' . $user->profile_picture);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image = $request->file('profile_picture');
            $imageName = 'user_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $user->update(['profile_picture' => $imageName]);
        }

        // Update or create profile
        $profileData = [
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip' => $request->zip,
            'alternative_phone' => $request->alternative_phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ];

        if ($user->profile) {
            $user->profile->update($profileData);
        } else {
            Profile::create(array_merge(['user_id' => $user->id], $profileData));
        }

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Profile Updated',
            'message' => 'Profile updated successfully',
            'type' => 'success',
            'icon' => 'fa-user-edit',
        ]);

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'Password Changed',
            'message' => 'Password changed successfully',
            'type' => 'success',
            'icon' => 'fa-key',
        ]);

        return redirect()->route('profile')->with('success', 'Password changed successfully');
    }
}
