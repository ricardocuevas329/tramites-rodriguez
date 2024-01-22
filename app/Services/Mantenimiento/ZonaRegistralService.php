<?php

namespace App\Services\Mantenimiento;

use App\Dtos\ZonaRegistral\ZonaRegistralDto;
use App\Http\Resources\CollectionResource;
use App\Models\Mantenimiento\ZonaRegistral;
use App\Traits\GenerateCode;
use Illuminate\Http\Request;


class ZonaRegistralService
{

    use GenerateCode;

    public function get(Request $request)
    {

        $filtro = $request->search;
        $area = ZonaRegistral::where(function ($query) use ($filtro) {
            $query->filtros($filtro);
        })->orderBy('s_codigo', 'desc')
            ->paginate(5);

        return CollectionResource::collection($area);
    }


    public function store(ZonaRegistralDto $dto): ZonaRegistral
    {
        $tableName = (new ZonaRegistral())->getTable();
        return ZonaRegistral::create([
            's_codigo' => $this->generateCode($tableName, 's_codigo', 5, 'ZR'),
            's_nombre' => $dto->s_nombre,
            's_codigo_sbs' => $dto->s_codigo_sbs,
            'i_estado' => 1
        ]);
    }

    public function update(ZonaRegistral $zonaregistral, ZonaRegistralDto $dto)
    {
        return $zonaregistral->update([
            's_nombre' => $dto->s_nombre,
            's_codigo_sbs' => $dto->s_codigo_sbs,
        ]);
    }

    public function findById(ZonaRegistral $zonaregistral): ZonaRegistral
    {
        return $zonaregistral;
    }


    public function disabled(ZonaRegistral $zonaregistral): ZonaRegistral
    {
        return tap($zonaregistral)->update([
            'i_estado' => 0,
        ]);
    }

    public function enabled(ZonaRegistral $zonaregistral): ZonaRegistral
    {
        return tap($zonaregistral)->update([
            'i_estado' => 1,
        ]);
    }

    public function destroy(ZonaRegistral $zonaregistral): ZonaRegistral
    {
        return tap($zonaregistral)->delete();
    }
}
