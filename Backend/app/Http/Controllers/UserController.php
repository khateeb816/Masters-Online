<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'phone' => 'nullable',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address_line_1' => 'nullable',
            'address_line_2' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip' => 'nullable',
            'alternative_phone' => 'nullable',
            'date_of_birth' => 'required',
            'gender' => 'required',
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => $request->status != null ? 'active' : 'inactive',
            'profile_picture' => $imageName ?? null,
        ]);
        $profile = Profile::create([
            'user_id' => $user->id,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip' => $request->zip,
            'alternative_phone' => $request->alternative_phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
        ]);
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = 'user_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
        }

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'User Created',
            'message' => 'User ' . $user->first_name . ' ' . $user->last_name . ' created successfully',
            'type' => 'success',
            'icon' => 'fa-user-plus',
        ]);

        return redirect()->route('users')->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' created successfully');
    }
    public function show($id)
    {
        $user = User::with('profile')->find($id);
        return view('pages.users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = User::with('profile')->find($id);
        return view('pages.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::with('profile')->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Validate the request
        $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'username' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'password' => 'nullable|min:6',
            'password_confirmation' => 'nullable|same:password',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'address_line_1' => 'nullable',
            'address_line_2' => 'nullable',
            'city' => 'nullable',
            'state' => 'nullable',
            'country' => 'nullable',
            'zip' => 'nullable',
            'alternative_phone' => 'nullable',
            'date_of_birth' => 'nullable',
            'gender' => 'nullable',
        ]);

        // Update user fields if not null
        $userData = [];

        if ($request->filled('first_name')) {
            $userData['first_name'] = $request->first_name;
        }

        if ($request->filled('last_name')) {
            $userData['last_name'] = $request->last_name;
        }

        if ($request->filled('username')) {
            $userData['username'] = $request->username;
        }

        if ($request->filled('email')) {
            $userData['email'] = $request->email;
        }

        if ($request->filled('phone')) {
            $userData['phone'] = $request->phone;
        }

        $userData['status'] = $request->status != null ? 'active' : 'inactive';


        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $imageName = 'user_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $userData['profile_picture'] = $imageName;
        }

        // Update user if there are changes
        if (!empty($userData)) {
            $user->update($userData);
        }

        // Update profile fields if not null
        $profileData = [];

        if ($request->filled('address_line_1')) {
            $profileData['address_line_1'] = $request->address_line_1;
        }

        if ($request->filled('address_line_2')) {
            $profileData['address_line_2'] = $request->address_line_2;
        }

        if ($request->filled('city')) {
            $profileData['city'] = $request->city;
        }

        if ($request->filled('state')) {
            $profileData['state'] = $request->state;
        }

        if ($request->filled('country')) {
            $profileData['country'] = $request->country;
        }

        if ($request->filled('zip')) {
            $profileData['zip'] = $request->zip;
        }

        if ($request->filled('alternative_phone')) {
            $profileData['alternative_phone'] = $request->alternative_phone;
        }

        if ($request->filled('date_of_birth')) {
            $profileData['date_of_birth'] = $request->date_of_birth;
        }

        if ($request->filled('gender')) {
            $profileData['gender'] = $request->gender;
        }

        // Update profile if there are changes
        if (!empty($profileData) && $user->profile) {
            $user->profile->update($profileData);
        }

        Notification::create([

            'user_id' => auth()->user()->id,
            'title' => 'User Updated',
            'message' => 'User ' . $user->first_name . ' ' . $user->last_name . ' updated successfully',
            'type' => 'success',
            'icon' => 'fa-user-edit',
        ]);

        return redirect()->route('users')->with('success', 'User ' . $user->first_name . ' ' . $user->last_name . ' updated successfully');
    }
    public function delete($id)
    {
        $user = User::with('profile')->find($id);
        $admin = auth()->user();

        // Store user info before deletion for notification
        $deletedUserName = $user->first_name . ' ' . $user->last_name;
        $deletedUserEmail = $user->email;

        if ($user->profile_picture) {
            unlink(public_path('uploads/' . $user->profile_picture));
        }

        $user->delete();

        // Send notification to admin about the deletion
        Notification::create([
            'user_id' => $admin->id,
            'title' => 'User Deleted',
            'message' => "User '{$deletedUserName}' ({$deletedUserEmail}) has been deleted successfully",
            'type' => 'success',
            'icon' => 'fa-user-times',
        ]);

        return redirect()->route('users')->with('success', 'User ' . $deletedUserName . ' deleted successfully');
    }
}
