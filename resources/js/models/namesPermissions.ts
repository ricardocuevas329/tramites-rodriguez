export type NamePermissions =
    // Personal
    | "Modulo Personal"
    | "Listar Personal"
    | "Actualizar Personal"
    | "Crear Personal"
    | "Desactivar Personal"
    | "Activar Personal"

    // Abogado
    | "Modulo Abogado"
    | "Listar Abogado"
    | "Actualizar Abogado"
    | "Crear Abogado"
    | "Desactivar Abogado"
    | "Activar Abogado"

    // ClientExternal
    | "Modulo Cliente"
    | "Listar Cliente"
    | "Actualizar Cliente"
    | "Crear Cliente"
    | "Desactivar Cliente"
    | "Activar Cliente"

    // Empresa
    | "Modulo Empresa"
    | "Listar Empresa"
    | "Actualizar Empresa"
    | "Crear Empresa"
    | "Desactivar Empresa"
    | "Activar Empresa"

    // ADMINISTRACION
    // ENTIDAD
    | "Modulo RegistroDeposito"
    | "Listar RegistroDeposito"
    | "Actualizar RegistroDeposito"
    | "Crear RegistroDeposito"
    | "Desactivar RegistroDeposito"
    | "Activar RegistroDeposito"
    // Accion
    | "Modulo Accion"
    | "Listar Accion"
    | "Actualizar Accion"
    | "Crear Accion"
    | "Desactivar Accion"
    | "Activar Accion"

    // Area
    | "Modulo Area"
    | "Listar Area"
    | "Actualizar Area"
    | "Crear Area"
    | "Desactivar Area"
    | "Activar Area"

    // Banco
    | "Modulo Banco"
    | "Listar Banco"
    | "Actualizar Banco"
    | "Crear Banco"
    | "Desactivar Banco"
    | "Activar Banco"

    // Bien
    | "Modulo Bien"
    | "Listar Bien"
    | "Actualizar Bien"
    | "Crear Bien"
    | "Desactivar Bien"
    | "Activar Bien"

    // Configuracion
    | "Modulo ConfiguracionGeneral"
    | "Listar ConfiguracionGeneral"
    | "Actualizar ConfiguracionGeneral"
    | "Crear ConfiguracionGeneral"
    | "Desactivar ConfiguracionGeneral"
    | "Activar ConfiguracionGeneral"

    // Profesion
    | "Modulo Profesion"
    | "Listar Profesion"
    | "Actualizar Profesion"
    | "Crear Profesion"
    | "Desactivar Profesion"
    | "Activar Profesion"

    // TipoCambio
    | "Modulo TipoCambio"
    | "Listar TipoCambio"
    | "Actualizar TipoCambio"
    | "Crear TipoCambio"
    | "Desactivar TipoCambio"
    | "Activar TipoCambio"

    //MANTENIMIENTO

    // BancoDeposito
    | "Modulo BancoDeposito"
    | "Listar BancoDeposito"
    | "Actualizar BancoDeposito"
    | "Crear BancoDeposito"
    | "Desactivar BancoDeposito"
    | "Activar BancoDeposito"

    // Cargo
    | "Modulo Cargo"
    | "Listar Cargo"
    | "Actualizar Cargo"
    | "Crear Cargo"
    | "Desactivar Cargo"
    | "Activar Cargo"

    // CargoPublico
    | "Modulo CargoPublico"
    | "Listar CargoPublico"
    | "Actualizar CargoPublico"
    | "Crear CargoPublico"
    | "Desactivar CargoPublico"
    | "Activar CargoPublico"

    // DocumentoVenta
    | "Modulo DocumentoVenta"
    | "Listar DocumentoVenta"
    | "Actualizar DocumentoVenta"
    | "Crear DocumentoVenta"
    | "Desactivar DocumentoVenta"
    | "Activar DocumentoVenta"

    // ModoPago
    | "Modulo ModoPago"
    | "Listar ModoPago"
    | "Actualizar ModoPago"
    | "Crear ModoPago"
    | "Desactivar ModoPago"
    | "Activar ModoPago"

    // Nacionalidad
    | "Modulo Nacionalidad"
    | "Listar Nacionalidad"
    | "Actualizar Nacionalidad"
    | "Crear Nacionalidad"
    | "Desactivar Nacionalidad"
    | "Activar Nacionalidad"

    // Notario
    | "Modulo Notario"
    | "Listar Notario"
    | "Actualizar Notario"
    | "Crear Notario"
    | "Desactivar Notario"
    | "Activar Notario"

    // Pais
    | "Modulo Pais"
    | "Listar Pais"
    | "Actualizar Pais"
    | "Crear Pais"
    | "Desactivar Pais"
    | "Activar Pais"

    // Permiso
    | "Modulo Permiso"
    | "Listar Permiso"
    | "Actualizar Permiso"
    | "Crear Permiso"
    | "Desactivar Permiso"
    | "Activar Permiso"

    // Requisito
    | "Modulo Requisito"
    | "Listar Requisito"
    | "Actualizar Requisito"
    | "Crear Requisito"
    | "Desactivar Requisito"
    | "Activar Requisito"

    // Servicio
    | "Modulo Servicio"
    | "Listar Servicio"
    | "Actualizar Servicio"
    | "Crear Servicio"
    | "Desactivar Servicio"
    | "Activar Servicio"

    // TipoCompareciente
    | "Modulo TipoCompareciente"
    | "Listar TipoCompareciente"
    | "Actualizar TipoCompareciente"
    | "Crear TipoCompareciente"
    | "Desactivar TipoCompareciente"
    | "Activar TipoCompareciente"

    // TipoDocumento
    | "Modulo TipoDocumento"
    | "Listar TipoDocumento"
    | "Actualizar TipoDocumento"
    | "Crear TipoDocumento"
    | "Desactivar TipoDocumento"
    | "Activar TipoDocumento"

    // Ubigeo
    | "Modulo Ubigeo"
    | "Listar Ubigeo"
    | "Actualizar Ubigeo"
    | "Crear Ubigeo"
    | "Desactivar Ubigeo"
    | "Activar Ubigeo"

    // Unidad
    | "Modulo Unidad"
    | "Listar Unidad"
    | "Actualizar Unidad"
    | "Crear Unidad"
    | "Desactivar Unidad"
    | "Activar Unidad"

    // ZonaRegistral
    | "Modulo ZonaRegistral"
    | "Listar ZonaRegistral"
    | "Actualizar ZonaRegistral"
    | "Crear ZonaRegistral"
    | "Desactivar ZonaRegistral"
    | "Activar ZonaRegistral"

    // EXTRAPROTOCOLAR
    // Condicion
    | "Modulo Condicion"
    | "Listar Condicion"
    | "Actualizar Condicion"
    | "Crear Condicion"
    | "Desactivar Condicion"
    | "Activar Condicion"

    // PermisoViaje
    | "Modulo PermisoViaje"
    | "Listar PermisoViaje"
    | "Actualizar PermisoViaje"
    | "Crear PermisoViaje"
    | "Desactivar PermisoViaje"
    | "Activar PermisoViaje"
    // Mantenimiento
    // ComparecienteBloqueado
    | "Modulo ComparecienteBloqueado"
    | "Listar ComparecienteBloqueado"
    | "Actualizar ComparecienteBloqueado"
    | "Crear ComparecienteBloqueado"
    | "Desactivar ComparecienteBloqueado"
    | "Activar ComparecienteBloqueado"
     // TipoEstado
     | "Modulo TipoEstado"
     | "Listar TipoEstado"
     | "Actualizar TipoEstado"
     | "Crear TipoEstado"
     | "Desactivar TipoEstado"
     | "Activar TipoEstado"
    // LIBROS
    | "Modulo Libro"
    | "Listar Libro"
    | "Actualizar Libro"
    | "Crear Libro"
    | "Desactivar Libro"
    | "Activar Libro"
    // Carta
    | "Modulo Carta"
    | "Listar Carta"
    | "Actualizar Carta"
    | "Crear Carta"
    | "Desactivar Carta"
    | "Activar Carta"
    // Carta
    | "Modulo Diligencia"
    | "Listar Diligencia"
    | "Actualizar Diligencia"
    | "Crear Diligencia"
    | "Desactivar Diligencia"
    | "Activar Diligencia"
    // RetistroFirmas
    | "Modulo RegistroFirmas"
    | "Listar RegistroFirmas"
    | "Actualizar RegistroFirmas"
    | "Crear RegistroFirmas"
    | "Desactivar RegistroFirmas"
    | "Activar RegistroFirmas"
    // CopiasCerfificadas
    | "Modulo CopiasCerfificadas"
    | "Listar CopiasCerfificadas"
    | "Actualizar CopiasCerfificadas"
    | "Crear CopiasCerfificadas"
    | "Desactivar CopiasCerfificadas"
    | "Activar CopiasCerfificadas"
    // Kardex
    | "Modulo Kardex"
    | "Listar Kardex"
    | "Actualizar Kardex"
    | "Crear Kardex"
    | "Desactivar Kardex"
    | "Activar Kardex"
    // Registro Venta
    | "Modulo RegistroVenta"
    | "Listar RegistroVenta"
    | "Actualizar RegistroVenta"
    | "Crear RegistroVenta"
    | "Desactivar RegistroVenta"
    | "Activar RegistroVenta"
    ;

