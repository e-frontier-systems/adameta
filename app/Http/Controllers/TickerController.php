<?php

namespace App\Http\Controllers;

use App\Models\Ticker;
use Database\Factories\TickerFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Http\Responses\EmailVerificationNotificationSentResponse;
use const Grpc\STATUS_ALREADY_EXISTS;

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

    public function save(Request $request): JsonResponse|RedirectResponse
    {
        $name = mb_strtoupper(trim($request->post('name')));

        $count = Ticker::query()
            ->where('name', '=', $name)
            ->count();

        if ($count > 0) {
            return new JsonResponse('既に登録されています', 403);
        }

        $Ticker = new Ticker();
        $Ticker->user_id = $request->user()->id;
        $Ticker->name = $name;
        $Ticker->description = $request->post('description', '');
        $Ticker->save();

        return new RedirectResponse(route('pool'));
    }
}
