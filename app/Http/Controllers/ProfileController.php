<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Auth::user();
        return view('pages.profile.index', compact('profile'));
    }

    public function showEdit()
    {
        $profile = Auth::user();
        return view('pages.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'current_password' => ['required_with:password', 'nullable'],
            'password' => ['nullable', 'min:8', 'confirmed']
        ]);

        $user = User::find(Auth::user()->id);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('profile.edit')->withErrors(['current_password' => 'Current password is incorrect']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile')->with(['message' => 'Profile updated', 'alert' => 'alert-success']);
    }
}
