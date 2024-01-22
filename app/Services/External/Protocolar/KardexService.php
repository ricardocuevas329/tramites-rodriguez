<?php

namespace App\Services\External\Protocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\External\Kardex\SearchKardexRequest;
use App\Http\Requests\External\Kardex\StoreKardexAsignationRequest;
use App\Http\Resources\CollectionResource;
use App\Mail\SendKardexEmail;
use App\Models\External\Protocolar\ClientExternal;
use App\Models\Protocolar\Kardex;
use Illuminate\Support\Facades\Mail;

class KardexService extends Controller
{


    public function __construct()
    {
    }


    public function getKardex(SearchKardexRequest $request)
    {
        $number_kardex = $request->number_kardex;
        $kardex_cod = str_pad($number_kardex, 10, '0', STR_PAD_LEFT);
        $data = Kardex::where('s_kardex', $kardex_cod)->with(['cliente','empresa'])->limit(10)->get();
        return CollectionResource::collection($data);
    }

    public function getParticipants(string $kardex)
    {
        $kardex = Kardex::where('s_codigo', $kardex)->first();

        return CollectionResource::collection($kardex->participantes);

    }

    public function existsKardex(StoreKardexAsignationRequest $request): bool
    {
        $cod = $request->codigo;
        $kardex = $request->number_kardex;
        $kardex_cod = str_pad($kardex, 10, '0', STR_PAD_LEFT);

        return Kardex::where('s_tipokardex', $cod)
            ->where('s_kardex', $kardex_cod)
            ->exists();

    }

    public function saveAsignation(StoreKardexAsignationRequest $request)
    {
        $cod = $request->codigo;
        $kardex = $request->number_kardex;
        $cod_client = $request->cod_client;
        $kardex_cod = str_pad($kardex, 10, '0', STR_PAD_LEFT);
        $data = Kardex::where('s_tipokardex', $cod)
            ->where('s_kardex', $kardex_cod)
            ->first();

        $client = ClientExternal::find($cod_client);
        $client->kardex = $data->s_codigo;
        $client->save();

        return $client;
    }




}
