<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\TshirtImage;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    public function profile(User $user): View
    {
        $customer = null;
        $currentUser = auth()->user();

        if ($currentUser->id !== $user->id) {
            $user = $currentUser;
        }

        if ($user->user_type === 'C') {
            $customer = Customer::find($user->id); // Obtém uma instância de Customer com o ID 1
        }

        return view('profile.index', compact('user', 'customer'));
    }

    public function edit(User $user): View
    {
        $customer = null;

        if ($user->user_type === 'C') {
            $customer = Customer::find($user->id); // Obtém uma instância de Customer com o ID 1
        }

        return view('profile.edit', compact('user', 'customer'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
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

        if ($user->user_type === 'C') {
            $customer = Customer::find($user->id);

            $customerData = [
                'nif' => $data['nif'],
                'address' => $data['address'],
                'default_payment_type' => $data['default_payment_type'],
                'default_payment_ref' => $data['default_payment_ref'],
            ];

            $customer->update($customerData);

        }

        $htmlMessage = "$user->name was successfully updated!";
        return redirect()->route('profile', $user)
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
        return redirect()->route('profile', $user)->with('success', $htmlMessage);
    }

}
