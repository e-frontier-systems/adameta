<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use Database\Factories\TickerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;

class TickerController extends Controller
{
    public function list(Request $request): \Inertia\Response
    {
        $user = $request->user();

        $tickers = Ticker::where('user_id', $user->id)->get();

        return Inertia::render('Metadata', [
            'tickers' => $tickers,
        ]);
    }

    public function delete(Request $request): RedirectResponse
    {
        Ticker::query()
            ->where('name', '=', $request->name)
            ->delete();

        return new RedirectResponse(route('pool'));
    }

    public function save(Request $request): RedirectResponse
    {
        $Ticker = new Ticker();
        $Ticker->user_id = $request->user()->id;
        $Ticker->name = $request->post('name');
        $Ticker->description = $request->post('description', '');
        $Ticker->save();

        return new RedirectResponse(route('pool'));
    }
}
