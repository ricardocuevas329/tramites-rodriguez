<?php

namespace App\Http\Controllers\Protocolar;

use App\Dtos\Kardex\StoreKardexDto;
use App\Dtos\Presencias\StorePresenciaDto;
use App\Dtos\Presencias\UpdatePresenciaDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Protocolar\Presencia\StorePresenciaRequest;
use App\Http\Requests\Protocolar\Presencia\UpdatePresenciaRequest;
use App\Http\Requests\Protocolar\StoreKardexRequest;
use App\Http\Requests\Protocolar\UpdateKardexRequest;
use App\Models\Protocolar\Kardex;
use App\Models\Protocolar\Presencia;
use App\Services\Protocolar\PresenciaNotarialService;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class PresenciaNotarialController extends Controller
{

    use ApiResponser;

    protected array $permissions = [];


    public function __construct(
        protected PresenciaNotarialService $service,

    )
    {

    }

    public function list(Request $request): JsonResource
    {
        return $this->service->get($request);
    }

    public function store(StorePresenciaRequest $request): JsonResponse
    {
        $data = $this->service->store(
            StorePresenciaDto::fromApiRequest($request)
        );
        return $this->success($data , 'Bien Hecho, Presencia Notarial Guardada correctamente!');
    }

    public function update(UpdatePresenciaRequest $request, Presencia $payload): JsonResponse
    {

        $data = $this->service->update(
            $payload,
            UpdatePresenciaDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, Kardex Se actualizó correctamente!");
    }


    public function findById(string $id): JsonResponse
    {

        $data = $this->service->findById($id);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos");

    }


}
