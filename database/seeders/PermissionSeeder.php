<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // EXTRAPROTOCOLAR
        // Libros
        Permission::create(['name' => 'Modulo Libro', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Libro', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Libro', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Libro', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Libro', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Libro', 'guard_name' => 'sanctum']);
        // Condicion
        Permission::create(['name' => 'Modulo Condicion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Condicion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Condicion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Condicion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Condicion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Condicion', 'guard_name' => 'sanctum']);

        // PermisoViaje
        Permission::create(['name' => 'Modulo PermisoViaje', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar PermisoViaje', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar PermisoViaje', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear PermisoViaje', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar PermisoViaje', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar PermisoViaje', 'guard_name' => 'sanctum']);

        // ComparecienteBloqueado
        Permission::create(['name' => 'Modulo ComparecienteBloqueado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar ComparecienteBloqueado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar ComparecienteBloqueado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear ComparecienteBloqueado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar ComparecienteBloqueado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar ComparecienteBloqueado', 'guard_name' => 'sanctum']);

        // TipoEstado
        Permission::create(['name' => 'Modulo TipoEstado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar TipoEstado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar TipoEstado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear TipoEstado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar TipoEstado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar TipoEstado', 'guard_name' => 'sanctum']);


        //ENTIDAD

        // Personal
        Permission::create(['name' => 'Modulo Personal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Personal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Personal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Personal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Personal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Personal', 'guard_name' => 'sanctum']);

        // Abogado
        Permission::create(['name' => 'Modulo Abogado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Abogado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Abogado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Abogado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Abogado', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Abogado', 'guard_name' => 'sanctum']);


        // ClientExternal
        Permission::create(['name' => 'Modulo ClientExternal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar ClientExternal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar ClientExternal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear ClientExternal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar ClientExternal', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar ClientExternal', 'guard_name' => 'sanctum']);

        // Empresa
        Permission::create(['name' => 'Modulo Empresa', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Empresa', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Empresa', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Empresa', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Empresa', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Empresa', 'guard_name' => 'sanctum']);


        // ADMINISTRACION
        // Accion
        Permission::create(['name' => 'Modulo Accion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Accion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Accion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Accion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Accion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Accion', 'guard_name' => 'sanctum']);

        // Area
        Permission::create(['name' => 'Modulo Area', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Area', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Area', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Area', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Area', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Area', 'guard_name' => 'sanctum']);

        // Banco
        Permission::create(['name' => 'Modulo Banco', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Banco', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Banco', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Banco', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Banco', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Banco', 'guard_name' => 'sanctum']);


        // Bien
        Permission::create(['name' => 'Modulo Bien', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Bien', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Bien', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Bien', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Bien', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Bien', 'guard_name' => 'sanctum']);


        // Configuracion
        Permission::create(['name' => 'Modulo ConfiguracionGeneral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar ConfiguracionGeneral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar ConfiguracionGeneral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear ConfiguracionGeneral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar ConfiguracionGeneral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar ConfiguracionGeneral', 'guard_name' => 'sanctum']);

        // Profesion
        Permission::create(['name' => 'Modulo Profesion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Profesion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Profesion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Profesion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Profesion', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Profesion', 'guard_name' => 'sanctum']);

        // TipoCambio
        Permission::create(['name' => 'Modulo TipoCambio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar TipoCambio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar TipoCambio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear TipoCambio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar TipoCambio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar TipoCambio', 'guard_name' => 'sanctum']);


        //MANTENIMIENTO

        // BancoDeposito
        Permission::create(['name' => 'Modulo BancoDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar BancoDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar BancoDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear BancoDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar BancoDeposito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar BancoDeposito', 'guard_name' => 'sanctum']);

        // Cargo
        Permission::create(['name' => 'Modulo Cargo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Cargo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Cargo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Cargo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Cargo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Cargo', 'guard_name' => 'sanctum']);


        // CargoPublico
        Permission::create(['name' => 'Modulo CargoPublico', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar CargoPublico', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar CargoPublico', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear CargoPublico', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar CargoPublico', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar CargoPublico', 'guard_name' => 'sanctum']);

        // DocumentoVenta
        Permission::create(['name' => 'Modulo DocumentoVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar DocumentoVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar DocumentoVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear DocumentoVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar DocumentoVenta', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar DocumentoVenta', 'guard_name' => 'sanctum']);


        // ModoPago
        Permission::create(['name' => 'Modulo ModoPago', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar ModoPago', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar ModoPago', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear ModoPago', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar ModoPago', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar ModoPago', 'guard_name' => 'sanctum']);


        // Nacionalidad
        Permission::create(['name' => 'Modulo Nacionalidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Nacionalidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Nacionalidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Nacionalidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Nacionalidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Nacionalidad', 'guard_name' => 'sanctum']);


        // Notario
        Permission::create(['name' => 'Modulo Notario', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Notario', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Notario', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Notario', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Notario', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Notario', 'guard_name' => 'sanctum']);

        // Pais
        Permission::create(['name' => 'Modulo Pais', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Pais', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Pais', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Pais', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Pais', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Pais', 'guard_name' => 'sanctum']);

        // Permiso
        Permission::create(['name' => 'Modulo Permiso', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Permiso', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Permiso', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Permiso', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Permiso', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Permiso', 'guard_name' => 'sanctum']);

        // Requisito
        Permission::create(['name' => 'Modulo Requisito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Requisito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Requisito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Requisito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Requisito', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Requisito', 'guard_name' => 'sanctum']);

        // Servicio
        Permission::create(['name' => 'Modulo Servicio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Servicio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Servicio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Servicio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Servicio', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Servicio', 'guard_name' => 'sanctum']);

        // TipoCompareciente
        Permission::create(['name' => 'Modulo TipoCompareciente', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar TipoCompareciente', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar TipoCompareciente', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear TipoCompareciente', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar TipoCompareciente', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar TipoCompareciente', 'guard_name' => 'sanctum']);


        // TipoDocumento
        Permission::create(['name' => 'Modulo TipoDocumento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar TipoDocumento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar TipoDocumento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear TipoDocumento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar TipoDocumento', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar TipoDocumento', 'guard_name' => 'sanctum']);

        // Ubigeo
        Permission::create(['name' => 'Modulo Ubigeo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Ubigeo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Ubigeo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Ubigeo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Ubigeo', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Ubigeo', 'guard_name' => 'sanctum']);

        // Unidad
        Permission::create(['name' => 'Modulo Unidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar Unidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar Unidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear Unidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar Unidad', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar Unidad', 'guard_name' => 'sanctum']);

        // ZonaRegistral
        Permission::create(['name' => 'Modulo ZonaRegistral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Listar ZonaRegistral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Actualizar ZonaRegistral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Crear ZonaRegistral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Desactivar ZonaRegistral', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'Activar ZonaRegistral', 'guard_name' => 'sanctum']);


    }
}
