<?php
namespace App\Traits;


trait StringManipulation
{

    public function getIniciales(string $cadena)
    {
        $palabras = explode(' ', $cadena); 
        $iniciales = '';

        foreach ($palabras as $palabra) {
            $iniciales .= strtoupper(substr($palabra, 0, 1)); 
        }

        return $iniciales;
    }
}
