<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserController extends Controller
{
    public function profile(Request $request): View
    {
        return view('profile.index');
    }

    public function dashboard(Request $request): View
    {
        return view('dashboard.index');
    }
}
