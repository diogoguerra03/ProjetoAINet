<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function profile(Request $request): View
    {
        $user = User::find($request->user()->id);

        return view('profile.index', ['user' => $user]);
    }

    public function dashboard(Request $request): View
    {
        return view('dashboard.index');
    }

    public function edit(User $user): View
    {
        $this->authorize('update', $user);

        return view('profile.edit', ['user' => $user]);
    }


    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $this->authorize('update', $user);


    }


}
