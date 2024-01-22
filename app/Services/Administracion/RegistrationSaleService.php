<?php

namespace App\Services\Administracion;

use App\Dtos\RegistroDeposito\FormRegistroDepositoDto;
use App\Dtos\RegistroVenta\StoreRegistrationSaleDto;
use App\Http\Resources\CollectionResource;
use App\Models\Administracion\DepositosDetalle;
use App\Models\Administracion\RegistroDeposito;
use App\Models\ExtraProtocolar\DetalleRecibo;
use App\Models\ExtraProtocolar\ReciboPago;
use App\Traits\UploadFileStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationSaleService
{

    use UploadFileStorage;
    public function __construct(

    )
    {
    }

    public function get(Request $request)
    {

            $filtro = $request->search;
            $data = ReciboPago::where(function ($query) use ($filtro) {
                 $query->filtros($filtro);
            })
            ->with(['cliente','empresa','documento_caja'])
            ->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($data);
    }


    public function store(StoreRegistrationSaleDto $dto): ReciboPago
    {
        $detail_services = $dto->detail_services;
        $invoice = json_encode($dto->invoice);
        $arrayInvoce = json_decode($invoice); 
        $sales = json_encode($dto->sales);
        $arraySales = json_decode($sales); 

        $data = new ReciboPago();
        $data->d_fechaVencimiento = $arraySales?->fecha_vencimiento;
        $data->s_serieunica =  $arraySales?->serie;
        $data->s_numeroSerie =  $arraySales?->numero;
        $data->save();

    
      /* if(count($detail_services)){
            foreach ($detail_services as $i => $value) {
                $detalle = new DetalleRecibo();
                $detalle->s_recibo = $data->s_codigo;
                $detalle->s_servicio = $value['servicio'];
                $detalle->de_precio =  (int) $value['precio'];
                $detalle->i_cantidad = (int) $value['cantidad'];
                $detalle->save();
            }
        }*/

        return $data;
    }

    public function update(RegistroDeposito $deposito, StoreRegistrationSaleDto $dto):bool
    {
        $detail_services = $dto->detail_services;
        $invoice = $dto->invoice;
        $sales = $dto->sales;
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

    public function findByExistNumSerie(string $num)
    {
        if(ReciboPago::where('s_serieunica',$num)->first()){
            return true;
        }

        return false;
      
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
