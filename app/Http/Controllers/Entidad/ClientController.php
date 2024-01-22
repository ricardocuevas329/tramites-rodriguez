<?php

namespace App\Http\Controllers\Entidad;

use App\Dtos\Cliente\ClienteDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Entidad\Cliente\{StoreClienteRequest, UpdateClienteRequest};
use App\Models\Entidad\Cliente;
use App\Services\Entidad\ClienteService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    use ApiResponser, MiddlewarePermission;

    protected $permissions = [];

    public function __construct(
        public ClienteService $service
    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request)
    {
        $this->verifyPermission($this->permissions, 'Listar ClientExternal');
        return $this->service->get($request);
    }

    public function search(Request $request)
    {
        return $this->service->search($request);
    }

    public function store(StoreClienteRequest $request)
    {
        $this->verifyPermission($this->permissions, 'Crear ClientExternal');
        if ($this->service->existClient($request->s_num_doc, $request->id_tipo_documento)) {
            return $this->error('ClientExternal ya existe, Registre otro!');
        }
        $data = $this->service->store(
            ClienteDto::fromApiRequest($request)
        );
        return $this->success($data, "Bien Hecho, ClientExternal Se Guardó correctamente!");
    }

    public function update(UpdateClienteRequest $request, Cliente $client)
    {
        $this->verifyPermission($this->permissions, 'Actualizar ClientExternal');
        if ($client->s_num_doc != $request->s_num_doc && $this->service->existClient($request->s_num_doc, $request->id_tipo_documento)) {
            return $this->error('ClientExternal ya existe, Registre otro!');
        }
        $data = $this->service->update(
            $client,
            ClienteDto::fromApiRequest($request)
        );

        return $this->success($data, "Bien Hecho, ClientExternal Se actualizó correctamente!");
    }


    public function findById(Cliente $client)
    {

        $this->verifyPermission($this->permissions, 'Actualizar ClientExternal');
        $data = $this->service->findById($client);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function findByDocument(Request $request)
    {
        $data = $this->service->findByDocument($request);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }

    public function disabled(Cliente $client)
    {
        $this->verifyPermission($this->permissions, 'Desactivar ClientExternal');
        $data = $this->service->disabled($client);
        if ($data) {
            return $this->success($data, "Desactivado Correctamente!");
        }
    }

    public function enabled(Cliente $client)
    {
        $this->verifyPermission($this->permissions, 'Activar ClientExternal');
        $data = $this->service->enabled($client);
        if ($data) {
            return $this->success($data, "Activado Correctamente!");
        }
    }

    public function findByDni(int $dni)
    {

        $data = $this->service->findByDni($dni);
        if ($data) {
            return $this->success($data);
        }
        return $this->error("No se encontraron datos", 422);
    }


}
