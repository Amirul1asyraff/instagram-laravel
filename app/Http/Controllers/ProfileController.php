<?php

namespace App\Http\Controllers;

use File;
use Storage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;


class ProfileController extends Controller
{
    public function show()
    {
        // Find or initialize a new Profile instance
        $profile = Profile::firstOrNew(['user_id' => auth()->id()]);

        // This ensures $profile is never null
        return view('profile.show', compact('profile'));
    }
    public function store(Request $request)
{
    $request->validate([
        'photo_profile' => 'required|image|max:2048',
    ]);

    $user = auth()->user();
    $fileName = $user->name . '_' . now()->format('Ymd_His') . '.' . $request->file('photo_profile')->getClientOriginalExtension();
    $imagePath = $request->file('photo_profile')->storeAs('profile', $fileName, 'public');

    // Handle file upload
    $profile = Profile::updateOrCreate(
        ['user_id' => $user->id],
        ['photo_profile' => $imagePath]
    );

    // Remove or move this debug statement if you want the code to continue execution
    // dd(request()->all());

    return redirect()->route('home')->with('success', 'Profile updated successfully!');
}
}
