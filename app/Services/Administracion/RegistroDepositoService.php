<?php

namespace App\Services\Administracion;

use App\Dtos\RegistroDeposito\FormRegistroDepositoDto;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\DepositosDetalle;
use App\Models\Administracion\RegistroDeposito;
use App\Traits\UploadFileStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroDepositoService
{

    use UploadFileStorage;
    public function __construct(

    )
    {
    }

    public function get(Request $request)
    {

            $filtro = $request->search;
            $data = RegistroDeposito::where(function ($query) use ($filtro) {
                $query->filtros($filtro);
            })->with(['aprobado', 'fotos'])->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(FormRegistroDepositoDto $dto): RegistroDeposito
    {
        $fotos = $dto->fotos;

        $deposito = RegistroDeposito::create($dto->toArray());
        if(count($fotos)){
            foreach ($fotos as $file => $value) {
                $url = $this->UploadFilesS3($value['base64'], "depositos", $value['type']);
                $detalle = new DepositosDetalle();
                $detalle->s_deposito = $deposito->s_codigo;
                $detalle->s_ruta = $url;
                $detalle->s_img = $url;
                $detalle->name = $value['name'];
                $detalle->type = $value['type'];
                $detalle->size = $value['size'];
                $detalle->file = $url;
                $detalle->i_estado = 1;
                $detalle->save();

            }
        }

        return $deposito;
    }

    public function update(RegistroDeposito $deposito, FormRegistroDepositoDto $dto):bool
    {
        $fotos = $dto->fotos;
        $success = $deposito->update($dto->toArray());
        if(count($fotos)){
            foreach ($fotos as $file => $value) {
                if(isset($value['base64'])){
                    $url = $this->UploadFilesS3($value['base64'], "depositos", $value['type']);
                    $detalle = new DepositosDetalle();
                    $detalle->s_deposito = $deposito->s_codigo;
                    $detalle->s_ruta = $url;
                    $detalle->s_img = $url;
                    $detalle->name = $value['name'];
                    $detalle->type = $value['type'];
                    $detalle->size = $value['size'];
                    $detalle->file = $url;
                    $detalle->i_estado = 1;
                    $detalle->save();
                }
            }
        }
        return $success;
    }

    public function findById(string $id)
    {
        $data = RegistroDeposito::findOrFail($id);
        return array_merge($data->toArray(), [
            'fotos' => $data->fotos,
        ]);

    }


    public function disabled(RegistroDeposito $registrodeposito): RegistroDeposito
    {
        return tap($registrodeposito)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(RegistroDeposito $registrodeposito): RegistroDeposito
    {
        return tap($registrodeposito)->update([
            'i_estado' => 1,
        ]);
    }




    public function destroy(RegistroDeposito $registrodeposito): RegistroDeposito
    {
        return $this->disabled($registrodeposito);
    }

    public function aprove(string $id): RegistroDeposito
    {
         $register = RegistroDeposito::find($id);
         $register->s_aprobado = Auth::user()->s_codigo;
         $register->d_fecha_aprob = date("Y-m-d H:i:s");
         $register->save();
         return $register;
    }

}
