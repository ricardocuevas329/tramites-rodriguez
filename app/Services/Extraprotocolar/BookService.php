<?php

namespace App\Services\ExtraProtocolar;

use App\Dtos\LibroDocument\StoreLibroDocumentDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExtraProtocolar\Libro\FilterLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\PrecioLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\StoreLibroRequest;
use App\Http\Requests\ExtraProtocolar\Libro\UpdateDateOpeningRequest;
use App\Http\Requests\ExtraProtocolar\Libro\UpdateObservationRequest;
use App\Http\Resources\CollectionResource;
use App\Models\External\Extraprotocolar\PermisoViajeExternal;
use App\Models\ExtraProtocolar\Libro;
use App\Models\ExtraProtocolar\LibroDocument;
use App\Models\ExtraProtocolar\LibroOrden;
use App\Models\Mantenimiento\Arancel;
use App\Models\Mantenimiento\Servicio;
use App\Services\Entidad\ClienteService;
use App\Services\Entidad\EmpresaService;
use App\Traits\GenerateCode;
use App\Traits\TemplatesExcel\ExtraProtocolar\GenerateDocumentPermisoViajeExcel;
use App\Traits\TemplatesPDF\ExtraProtocolar\GenerateDocumentLibroPDF;
use App\Traits\TemplatesWord\ExtraProtocolar\GenerateDocumentLibro;
use App\Traits\UploadFileStorage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookService extends Controller
{

    use GenerateCode, GenerateDocumentLibro, UploadFileStorage, GenerateDocumentPermisoViajeExcel, GenerateDocumentLibroPDF;

    public function __construct(
        protected ClienteService              $clienteService,
        protected ParticipanteService         $participanteService,
        protected BookDocumentService $bookDocumentService,
        protected EmpresaService              $empresaService
    )
    {
    }

    public function get(Request $request): JsonResource
    {

        $filtro = $request->search;
        $data = Libro::with(['empresa'])
            ->orderBy('s_libro', 'desc')
            ->where(function ($query) use ($filtro) {
                $query->Filtros($filtro);
            })
            ->active()
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function getExterno(Request $request): JsonResource
    {
        $filtro = $request->search;
        $data = PermisoViajeExternal::with(['participantes', 'files'])
            ->orderBy('id', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }

    public function store(StoreLibroRequest $request): Libro|bool
    {
        $files = $request->input('files');
        $cod = $this->generateCode((new LibroOrden())->getTable(), 's_codigo', 12, 'LI');
        $book_order = new LibroOrden();
        $book_order->s_codigo = $cod;
        $book_order->save();
        if ($book_order->s_codigo) {
            $libros_legalizados = $request->libros_legalizados;
            if ($libros_legalizados && count($libros_legalizados)) {
                foreach ($libros_legalizados as $item => $value) {
                    $book = new Libro();
                    $book->s_codigo = $book_order->s_codigo;
                    $book->d_fecha_cierre = isset($request->fecha_termino) ? $request->fecha_termino : '';
                    $book->i_tipopago = $request->contado ? 1 : 0;
                    $book->s_observacion = $request->observacion;
                    $book->s_cliente = $request->dni_id_doc;
                    $book->s_empresa = $request->ruc_id_doc;
                    $book->s_facturar = $request->ruc_facturado_id_cod;
                    $book->s_representante = $request->dni_representa_id_doc;

                    $book->s_denominacion = $value["denominado"];
                    $book->s_folios = $value["folios"];
                    $book->s_forma = $value["formas"];
                    $book->s_precio = $value["precios"];
                    $book->s_cantidad = '1';
                    $book->s_numero_libro = 'N° '.$value["numero"];
                 
                    //pendiente $book->s_libro = $value["libro"];
                    $book->save();

                    if (str_starts_with($book->s_cliente, 'CL')) {
                        $client = $this->clienteService->find($book->s_cliente);
                        $client->s_correo = $request->correo;
                        $client->s_celular = $request->telefono;
                        $client->save();
                    } else {
                        $company = $this->empresaService->find($book->s_cliente);
                        $company->s_email = $request->correo;
                        $company->s_telefono = $request->telefono;
                        $company->save();
                    }


                }

                if ($files && count($files)) {
                    foreach ($files as $file => $value) {
                        if (isset($value['base64'])) {
                            $folder = 'libros-documents';
                            $this->bookDocumentService->store(
                                new StoreLibroDocumentDto(
                                    file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                                    id_libro: $book->s_codigo,
                                    name: $value['name'],
                                    size: $value['size'],
                                    type: $value['type'],
                                )
                            );
                        }
                    }
                }

                return true;
            }
        }
        return false;

    }

    public function update(StoreLibroRequest $request, string $cod_libro): Libro|bool
    {

        $book_legalecy = $request->libros_legalizados;
        $files = $request->input('files');

        if ($book_legalecy && count($book_legalecy)) {
            foreach ($book_legalecy as $item => $value) {
                $book = Libro::find($value['libro']);
                $book->d_fecha_cierre = isset($request->fecha_termino) ? $request->fecha_termino : '';
                $book->i_tipopago = $request->contado ? 1 : 0;
                $book->s_observacion = $request->observacion;
                $book->s_cliente = $request->dni_id_doc;
                $book->s_empresa = $request->ruc_id_doc;
                $book->s_facturar = $request->ruc_facturado_id_cod;
                $book->s_representante = $request->dni_representa_id_doc;

                $book->s_denominacion = $value["denominado"];
                $book->s_folios = $value["folios"];
                $book->s_forma = $value["formas"];
                $book->s_precio = $value["precios"];
                $book->s_cantidad = '1';
                $book->s_numero_libro = $value["numero"];
                
                //pendiente $book->s_libro = $value["libro"];
                $book->save();


                if (str_starts_with($book->s_cliente, 'CL')) {
                    $client = $this->clienteService->find($book->s_cliente);
                    $client->s_correo = $request->correo;
                    $client->s_celular = $request->telefono;
                    $client->save();
                } else {
                    $company = $this->empresaService->find($book->s_cliente);
                    $company->s_email = $request->correo;
                    $company->s_telefono = $request->telefono;
                    $company->save();
                }


            }
            if ($files && count($files)) {
                foreach ($files as $file => $value) {

                    if (isset($value['base64'])) {
                        $folder = 'libro-documents';
                        $this->bookDocumentService->store(
                            new StoreLibroDocumentDto(
                                file: $this->UploadFilesS3($value['base64'], $folder, $value['type']),
                                id_libro: $book->s_codigo,
                                name: $value['name'],
                                size: $value['size'],
                                type: $value['type'],
                            )
                        );
                    }
                }
            }
            return true;
        }

        return false;
    }


    public function updateObservation(UpdateObservationRequest $request, string $cod_book): Libro|bool
    {
        return Libro::whereIn('s_codigo', [$cod_book])->active()->update([
            's_observacion' => $request->observacion
        ]);
    }

    public function updateDateOpening(UpdateDateOpeningRequest $request, string $cod_book): Libro|bool
    {

        return Libro::whereIn('s_codigo', [$cod_book])->active()->update([
            'd_fecha_apertura' => $request->fecha
        ]);
    }

    public function findById(string $code)
    {

        return Libro::with(['empresa', 'representante', 'facturado','files'])
            ->where('s_codigo', $code)
            ->get();
    }

    public function findPayment(string $code)
    {
        return Libro::with(['empresa', 'representante', 'facturado', 'detalle_recibo'])
            ->where('s_codigo', $code)
            ->first();
    }


    public function disabled(Libro $book): Libro
    {
        return tap($book)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(Libro $book): Libro
    {
        return tap($book)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(Libro $book): Libro
    {
        return $this->disabled($book);
    }

    public function generateDocument(Libro $book)
    {
        return $this->createDocumentWord($book);
    }

    public function generateExcel(Libro $book)
    {
        return $this->exportExcel($book);
    }

    public function generatePDF(Libro $book)
    {
        return $this->exportPDF($book);
    }

    public function searchBook(FilterLibroRequest $request): JsonResource
    {
        $search = $request->search;
        $codes = [
            'SE110', 'SE118', 'SE119', 'SE120', 'SE121', 'SE122', 'SE123', 'SE107',
            'SE108', 'SE109', 'SE105', 'SE106', 'SE111', 'SE116', 'SE117', 'SE124',
            'SE128', 'SE129', 'SE130', 'SE131', 'SE132', 'SE232'
        ];

        $data = Servicio::whereIn('s_codigo', $codes)
            ->nombre($search)
            ->orderBy('s_nombre', 'asc')
            ->limit(10)
            ->get();

        return CollectionResource::collection($data);

    }

    public function getPrice(PrecioLibroRequest $request): Arancel
    {
        return Arancel::servicio($request->servicio)->first();
    }

    public function countFiles(string $id_book): bool
    {
        $data = Libro::where('s_codigo', $id_book)->withCount('files')->first();
        if ($data->files_count == 1) {
            return false;
        }
        return true;
    }
    public function deleteDocument(int $id_document): LibroDocument
    {
        $document = LibroDocument::find($id_document);
        return $this->bookDocumentService->destroy($document);
    }

}
