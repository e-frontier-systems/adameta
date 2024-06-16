<?php
namespace App\Http\Controllers;

use App\Models\Ticker;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PoolController extends Controller
{
    //
    public function index(Request $request)
    {
        $tickers = Ticker::where('user_id', $request->user()->id)->get();

        return Inertia::render('Pool', [
            'pools' => $tickers,
        ]);
    }
}
