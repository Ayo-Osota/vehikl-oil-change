<?php

namespace App\Http\Controllers;

use App\Models\OilCheck;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OilChangeController extends Controller
{
    public function index()
    {
        return view('oil-change');
    }

    public function check(Request $request)
{
    $validated = $request->validate([
        'current_odometer' => ['required', 'numeric', 'min:0'],
        'last_change_odometer' => ['required', 'numeric', 'min:0'],
        'last_change_date' => ['required', 'date', 'before:today'],
    ], [
        'last_change_date.before' => 'The date of previous oil change must be in the past.',
    ]);

    if ($validated['current_odometer'] < $validated['last_change_odometer']) {
        throw ValidationException::withMessages([
            'current_odometer' => 'The current odometer must be greater than or equal to the odometer at previous oil change.',
        ]);
    }

    $kmSinceChange = $validated['current_odometer'] - $validated['last_change_odometer'];

    $monthsSinceChange = Carbon::parse($validated['last_change_date'])
        ->diffInMonths(now());

    $needsChange = $kmSinceChange > 5000 || $monthsSinceChange > 6;

    $oilCheck = OilCheck::create([
        'current_odometer' => $validated['current_odometer'],
        'last_change_odometer' => $validated['last_change_odometer'],
        'last_change_date' => $validated['last_change_date'],
        'needs_change' => $needsChange,
    ]);

    return redirect()->route('oil-change.result', $oilCheck);
}

    public function result(OilCheck $oilCheck)
    {
        $kmSinceChange = $oilCheck->current_odometer - $oilCheck->last_change_odometer;
        $monthsSinceChange = $oilCheck->last_change_date->diffInMonths(Carbon::today());

        $reasons = [];
        if ($kmSinceChange > 5000) {
            $reasons[] = "Driven {$kmSinceChange} km since last oil change (limit: 5,000 km).";
        }
        if ($monthsSinceChange > 6) {
            $reasons[] = "{$monthsSinceChange} months since last oil change (limit: 6 months).";
        }

        return view('oil-change-result', [
            'oilCheck' => $oilCheck,
            'needsChange' => $oilCheck->needs_change,
            'reasons' => $reasons,
            'kmSinceChange' => $kmSinceChange,
            'monthsSinceChange' => $monthsSinceChange,
        ]);
    }
}
