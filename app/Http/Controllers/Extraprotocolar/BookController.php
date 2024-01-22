<?php

namespace App\Http\Controllers\Extraprotocolar;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\Libro\FilterLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\PrecioLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\StoreLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\UpdateDateOpeningRequest;
use App\Http\Requests\ExtraProtocolar\Libro\UpdateObservationRequest;
use App\Models\ExtraProtocolar\Libro;
use App\Services\Extraprotocolar\BookDocumentService;
use App\Services\ExtraProtocolar\BookService;
use App\Traits\ApiResponser;
use App\Traits\MiddlewarePermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    use ApiResponser, MiddlewarePermission;

    protected array $permissions = [];

    public function __construct(
        protected BookService         $service,
        protected BookDocumentService $bookDocumentService
    )
    {
        $this->middleware(function ($request, $next) {
            $this->permissions = Auth::user()?->permissions->pluck('name')->toArray();
            return $next($request);
        });
    }

    public function list(Request $request): JsonResource
    {
        $this->verifyPermission($this->permissions, 'Listar Libro');
        return $this->service->get($request);
    }

    public function store(StoreLibroRequest $request): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Crear Libro');

        if (count($request->get('libros_legalizados')) == 0) {
            return $this->error("Agregue al menos 1 Libro!");
        }

        $data = $this->service->store($request);
        return $this->success($data, 'Guardado correctamente!');
    }


    public function update(StoreLibroRequest $request, string $cod_book): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar Libro');

        if (count($request->get('libros_legalizados')) == 0) {
            return $this->error("Agregue al menos 1 Libro!");
        }

        $data = $this->service->update($request, $cod_book);
        return $this->success($data, 'Guardado correctamente!');
    }

    public function updateObservation(UpdateObservationRequest $request, string $cod_book): JsonResponse
    {
        $data = $this->service->updateObservation($request, $cod_book);
        return $this->success($data, 'Guardado correctamente!');
    }

    public function updateDateOpening(UpdateDateOpeningRequest $request, string $cod_book): JsonResponse
    {
        $data = $this->service->updateDateOpening($request, $cod_book);
        return $this->success($data, 'Fecha Guardada correctamente!');
    }

    public function findById(string $code): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Actualizar Libro');

        $libro = $this->service->findById($code);
        if ($libro) {
            return $this->success($libro);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function findPayment(string $code): JsonResponse
    {

        $data = $this->service->findPayment($code);
        if ($data) {
            return $this->success($data);
        }

        return $this->error("No se encontraron datos", 422);

    }

    public function disabled(Libro $book): JsonResponse
    {

        $this->verifyPermission($this->permissions, 'Desactivar Libro');
        $data = $this->service->disabled($book);
        return $this->success($data, "Desactivado Correctamente!");
    }

    public function enabled(Libro $book): JsonResponse
    {
        $this->verifyPermission($this->permissions, 'Activar Libro');
        $data = $this->service->enabled($book);
        return $this->success($data, "Activado Correctamente!");
    }

    public function generateDocument(Libro $book)
    {
        $data = $this->service->generateDocument($book);
        if ($data) {
            return $data;
        }

    }

    public function generateExcel(Libro $book)
    {
        $data = $this->service->generateExcel($book);
        if ($data) {
            return $data;
        }
    }

    public function generatePDF(Libro $book)
    {
        $data = $this->service->generatePDF($book);
        if ($data) {
            return $data;
        }
    }


    public function filter(FilterLibroRequest $request)
    {
        return $this->service->searchBook($request);
    }

    public function getPrice(PrecioLibroRequest $request)
    {
        return $this->success($this->service->getPrice($request));

    }


    public function delete_document(int $id_document): JsonResponse
    {
        try {
            if ($this->service->countFiles($this->bookDocumentService->find($id_document)->id_libro)) {
                $document = $this->service->deleteDocument($id_document);
                return $this->success($document, "Documento Eliminado Correctamente!");
            } else {
                return $this->error("No está permitido eliminar todos los Documentos!");
            }
        } catch (\Exception $e) {
            return $this->error("Ocurrió un error, Intentelo nuevamente!");

        }
    }

}
