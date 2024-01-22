<?php

namespace App\Dtos\RegistroDeposito;
use App\Http\Requests\Administracion\RegistroDeposito\StoreRegistroDepositoRequest;
use App\Http\Requests\Administracion\RegistroDeposito\UpdateRegistroDepositoRequest;

class FormRegistroDepositoDto
{
    public function __construct(

        public readonly ?string $s_kardex,
        public readonly ?string $s_tipo,
        public readonly ?string $s_banco,
        public readonly ?string $d_fecha_ope,
        public readonly ?string $s_num_ope,
        public readonly ?string $i_monto,
        public readonly ?string $s_comentario,
        public readonly ?array $fotos,
        public readonly ?string $tipo_kardex,
        public readonly ?string $banco_name,
    )
    {
    }

    public function toArray()
    {
        return [
            's_kardex' => $this->tipo_kardex.$this->s_kardex,
            's_tipo' => $this->s_tipo,
            's_banco' => $this->s_banco.' -'.$this->banco_name,
            'd_fecha_ope' => $this->d_fecha_ope,
            's_num_ope' => $this->s_num_ope,
            'i_monto' => $this->i_monto,
            's_comentario' => $this->s_comentario,
        ];
    }

    public static function fromApiRequest(StoreRegistroDepositoRequest|UpdateRegistroDepositoRequest $request): FormRegistroDepositoDto
    {
        return new self(
            s_kardex: $request->validated('s_kardex'),
            s_tipo: $request->validated('s_tipo'),
            s_banco: $request->validated('s_banco'),
            d_fecha_ope: $request->validated('d_fecha_ope'),
            s_num_ope: $request->validated('s_num_ope'),
            i_monto: $request->validated('i_monto'),
            s_comentario: $request->validated('s_comentario'),
            fotos: $request->validated('fotos'),
            tipo_kardex: $request->validated('tipo_kardex'),
            banco_name: $request->validated('banco_name'),
        );
    }

}
