<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Requests\ColorRequest;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Color::class, 'color');
    }

    //Colors
    public function showColors(): View
    {
        $colors = Color::all('code', 'name');
        return view('dashboard.colors', compact('colors'));
    }

    public function deleteColor(string $code): RedirectResponse
    {
        $color = Color::find($code);
        if ($color) {
            $color->delete();

            return redirect()->back()
                ->with('alert-msg', "Color deleted successfully.")
                ->with('alert-type', 'success');
        } else {
            return redirect()->back()
                ->with('alert-msg', "Color not found.")
                ->with('alert-type', 'error');
        }
    }

    public function editColor(Color $color): View
    {
        return view('dashboard.editColor', compact('color'));
    }

    public function updateColor(ColorRequest $request, Color $color): RedirectResponse
    {
        $formData = $request->validated();

        $color = DB::transaction(function () use ($formData, $color) {
            $color->name = $formData['name'];
            $color->code = $formData['code'];

            $color->save();

            return $color;
        });

        $htmlMessage = "Color $color->name was successfully updated!";

        return redirect()->route('dashboard.showColors')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

    public function addColor(): View
    {
        return view('dashboard.addColor');
    }

    public function storeColor(ColorRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $color = DB::transaction(function () use ($data, $request) {
            $color = new Color();
            $color->code = $data['code'];
            $color->name = $data['name'];
            $color->save();
        });

        $htmlMessage = "Color was successfully created!";

        return redirect()->route('dashboard.showColors')
            ->with('alert-msg', $htmlMessage)
            ->with('alert-type', 'success');
    }

}
