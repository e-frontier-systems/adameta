<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetadataUpdateRequest;
use App\Models\Metadata;
use App\Models\Ticker;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MetadataController extends Controller
{
    public function getByTickerId(Request $request): JsonResponse
    {
        $metadata = DB::table('metadatas')
            ->where('ticker_id', '=', $request->get('ticker_id'))
            ->latest()->first();

        return new JsonResponse($metadata);
    }


    public function show($id, Request $request): View
    {
        $metadata = DB::table('metadatas')
            ->where('ticker_id', '=', $request->get('ticker_id'))
            ->latest()->first();

        return view('metadata.show', [
            'metadata' => $metadata,
        ]);
    }


    public function update(MetadataUpdateRequest $request)
    {
        $request->user()->fill($request->validated());

        $metadata = new Metadata();
        $metadata->id = null;
        $metadata->json = $request->get('json');
        $metadata->ticker_id = $request->get('ticker_id');
        $metadata->save();

        $metadata = DB::table('metadatas')
            ->where('ticker_id', '=', $request->get('ticker_id'))
            ->latest()->first();

        return Redirect::route('metadata.show', ['id' => $metadata->id])->with('status', 'metadata-updated');
    }


    public function showPublic($ticker_name)
    {
        $ticker = DB::table('tickers')
            ->where('name', '=', $ticker_name)
            ->latest()->first();
        if (!$ticker) {
            return JsonResponse::HTTP_NOT_FOUND;
        }

        $metadata = DB::table('metadatas')
            ->where('ticker_id', '=', $ticker->id)
            ->latest()->first();
        if (!$metadata) {
            return JsonResponse::HTTP_NOT_FOUND;
        }

        return JsonResponse::fromJsonString($metadata->json);
    }


    public function makePublic(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return JsonResponse::HTTP_UNAUTHORIZED;
        }

        $ticker_name = $request->post('ticker');
        $metadata = $request->post('metadata');

        $Ticker = new Ticker();
        $Ticker->name = $ticker_name;
        if (!$Ticker->save()) {
            return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        $Ticker = DB::table('tickers')
            ->where('name', '=', $ticker_name)
            ->latest()->first();
        if (!$Ticker) {
            return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        $Metadata = new Metadata();
        $Metadata->ticker_id = $Ticker->id;
        $Metadata->json = $metadata;
        if (!$Metadata->save()) {
            return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        $Metadata = DB::table('metadatas')
            ->where('ticker_id', '=', $Ticker->id)
            ->latest()->first();
        if (!$Metadata) {
            return JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        $text = route('public_metadata', ['ticker' => $Ticker->name]);

        return JsonResponse::fromJsonString("OK");
    }
}
