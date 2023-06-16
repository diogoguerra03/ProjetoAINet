<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function profile(): View
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);
        $user = Auth::user();

        return view('profile.edit', compact('user'));
    }


    public function update(UpdateUserRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $this->authorize('update', $user);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($user->photo_url) {
                Storage::delete('public/photos/' . $user->photo_url);
            }

            $path = $request->file('image')->store('public/photos');
            $filename = basename($path);
            $user->photo_url = $filename;
        }

        $user->update($data);

        $htmlMessage = "$user->name was successfully updated!";
        return redirect()->route('profile')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function deletePhoto(): RedirectResponse
    {
        $user = Auth::user();
        if ($user->photo_url) {
            Storage::delete('public/photos/' . $user->photo_url);
            $user->photo_url = null;
            $user->save();
        }

        $htmlMessage = "Photo deleted successfully.";
        return redirect()->route('profile')->with('success', $htmlMessage);
    }

}