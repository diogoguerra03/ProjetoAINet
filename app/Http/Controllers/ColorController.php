<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ColorRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ColorController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Color::class, 'color');
    }

    //Colors
    public function index(): View
    {
        $colors = Color::all('code', 'name');
        return view('dashboard.colors', compact('colors'));
    }

    public function delete(Color $color): RedirectResponse
    {
        if (count($color->orderItems) > 0) {
            $color->delete();
        } else if ($color->orderItems()->count() == 0) {
            Storage::delete('public/tshirt_base/' . $color->code . '.jpg');
            $color->forceDelete();

        } else {
            return redirect()->back()
                ->with('alert-msg', "Color not found.")
                ->with('alert-type', 'error');
        }

        return redirect()->back()
            ->with('alert-msg', "Color deleted successfully.")
            ->with('alert-type', 'success');
    }

    public function edit(Color $color): View
    {
        return view('dashboard.editColor', compact('color'));
    }

    public function update(ColorRequest $request, Color $color): RedirectResponse
    {
        $formData = $request->validated();

        if ($color->orderItems()->count() != 0)
            return redirect()->route('dashboard.showColors')
                ->with('alert-msg', "Color can't be updated.")
                ->with('alert-type', 'error');

        $color = DB::transaction(function () use ($formData, $color) {
            $color->name = $formData['name'];
            $color->code = $formData['code'];
            Storage::delete('public/tshirt_base/' . $color->code . '.jpg');
            Storage::putFileAs('public/tshirt_base', $formData['image'], $color->code . '.jpg');

            $color->save();

            return $color;
        });

        $htmlMessage = "Color $color->name was successfully updated!";

        return redirect()->route('dashboard.showColors')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function create(): View
    {
        return view('dashboard.addColor');
    }

    public function store(ColorRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $color = DB::transaction(function () use ($data, $request) {
            $color = new Color();
            $color->code = $data['code'];
            $color->name = $data['name'];
            Storage::putFileAs('public/tshirt_base', $request->file('image'), $color->code . '.jpg');
            $color->save();
        });

        $htmlMessage = "Color was successfully created!";

        return redirect()->route('dashboard.showColors')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

}