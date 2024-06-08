<?php

namespace App\Http\Controllers;

use App\Http\Requests\MetadataUpdateRequest;
use App\Models\Metadata;
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
}
