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



    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $formData = $request->validated();
        $user = DB::transaction(function () use ($formData, $user, $request) {
            $user->name = $formData['name'];
            $user->email = $formData['email'];

            if ($request->hasFile('image')) {
                if ($user->photo_url) {
                    Storage::delete('public/photos/' . $user->photo_url);
                }

                $path = $request->file('image')->store('public/photos');
                $filename = basename($path);
                $user->photo_url = $filename;
            }

            $user->save();

            return $user;
        });

        $url = route('catalog.show', $user->slug);
        $htmlMessage = "Product <a href='$url'>#{$user->id}</a>
                    <strong>\"{$user->name}\"</strong> was successfully updated!";

        return redirect()->route('catalog.index')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');

    }





}
