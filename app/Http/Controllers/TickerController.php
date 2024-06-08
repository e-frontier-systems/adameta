<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use Database\Factories\TickerFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;

class TickerController extends Controller
{
    public function list(Request $request): \Inertia\Response
    {
        $user = $request->user();

        $tickers = Ticker::where('user_id', $user->id)->get();

        return Inertia::render('Ticker', [
            'tickers' => $tickers,
        ]);
    }
}
