export interface Accion {
    // columns
    i_codigo: number
    s_codper: string|null
    s_nombre: string|null
    s_descripcion: string|null
    s_objeto: string|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
}

export interface Area {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_descarea: string|null
    i_estado: number|null
}

export interface Banco {
    // columns
    id_cod: number
    s_cod_pdt: string
    s_cod_cnl: string|null
    s_nombre: string|null
    s_abrev: string|null
    i_estado: number|null
}

export interface Bien {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_decripcion: string|null
    i_estado: number|null
    // mutators
    descripcion: string
}

export interface Configuracion {
    // columns
    i_codigo: number
    s_empresa: string|null
    s_direccion: string|null
    s_ruta_logo: string|null
    s_ruta_fondo_login: string|null
    d_fecha_registro: string|null
    s_hora_registro: string|null
    s_responsable: string|null
    s_descripcion: string|null
    i_estado: number|null
}

export interface DepositosDetalle {
    // columns
    s_codigo: number
    s_deposito: string
    s_ruta: string
    s_img: string
    i_estado: number
    file: string|null
    name: unknown
    type: string|null
    size: number|null
    // mutators
    filepond: string[]
    options: string[]
    source: string|null
}

export interface DetalleRango {
    // columns
    s_codigo: string
    s_servicios: string|null
    s_colum1: string|null
    s_colum2: string|null
    de_precio: number|null
}

export interface DocumentoCaja {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_abrev: string|null
    s_serie: string|null
    s_impresora: string|null
    i_tipo_comprobante_fe: number|null
    i_estado: number|null
}

export interface Profesion {
    // columns
    s_codigo: string
    s_codigo_sbs: string|null
    s_nombre: string|null
    s_nombref: string|null
    i_tipo: number|null
    s_descripcion: string|null
    i_estado: number|null
}

export interface RegistroDeposito {
    // columns
    i_codigo: number
    s_operacion: string|null
    d_fechadep: string|null
    s_descripcion: string|null
    de_monto: number|null
    s_referencia: string|null
    s_cuenta: string|null
    s_banco: string|null
    i_tipo: number|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    kardex: Kardex
    // relations
    aprobado: User
}

export interface TipoCambio {
    // columns
    s_codigo: string
    de_compra: number|null
    de_venta: number|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
}

export interface DatabaseNotification {
    // columns
    id: string
    type: string
    notifiable_type: string
    notifiable_id: number
    data: string[]
    read_at: string|null
    created_at: string|null
    updated_at: string|null
}

export interface Abogado {
    // columns
    s_codigo: string
    s_paterno: string|null
    s_materno: string|null
    s_nombres: string|null
    s_sexo: string|null
    s_telefono: string|null
    s_cal: string|null
    s_colegio: string|null
    s_personal: string|null
    i_estado: number|null
    // relations
    personal: User
}

export interface Cliente {
    // columns
    s_codigo: string
    s_paterno: string|null
    s_materno: string|null
    s_nombres: string|null
    s_tipo_docu: string|null
    s_num_doc: string|null
    d_fecha_nac: string|null
    s_estado_civil: string|null
    s_nacionalidad: string|null
    s_localidad: string|null
    s_direccion: string|null
    s_referencia: string|null
    s_sexo: string|null
    s_correo: string|null
    s_telefono: string|null
    s_celular: string|null
    s_pass: unknown|null
    s_profesion: string|null
    s_otro_profesion: string|null
    s_cargo: string|null
    s_otro_cargo: string|null
    i_residencia: number|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    nombre_compuesto: string
    nombre: string|null
    correo: string|null
    id_tipo_documento: string
    // relations
    tipo_documento: TipoDocumento
    ubigeo: Distrito
    nacionalidad: Nacionalidad
}

export interface ComparecienteBloqueado {
    // columns
    s_codigo: string
    s_referencia: string|null
    s_numero: string|null
    d_fecha_re: string|null
    s_condicion: string|null
    s_ruta: string|null
    s_personal: string|null
    i_estado: number|null
    created_at: string|null
    updated_at: string|null
    s_observacion: string
    // relations
    referencia: Estado
    condicion: Estado
    personal: User
    comparecientes: DetalleBloqueado[]
}

export interface DetalleBloqueado {
    // columns
    s_codigo: string
    s_codreg_bloq: string|null
    s_compareciente: string|null
    s_nombres: string|null
    s_paterno: string|null
    s_materno: string|null
    i_estado: number|null
}

export interface Empresa {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_tip_doc: string|null
    s_num_doc: string|null
    i_nacionalidad: number|null
    s_localidad: string|null
    s_direccion: string|null
    s_referencia: string|null
    s_email: string|null
    s_web: string|null
    s_telefono: string|null
    s_celular: string|null
    s_oficina: string|null
    s_partida: string|null
    s_registro: string|null
    s_ciiu: string|null
    s_objeto_social: string|null
    s_anotacion: string|null
    s_pass: unknown|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    correo: string|null
    nombre: string|null
    nombre_compuesto: string
    // relations
    nacionalidad: Nacionalidad
    tipo_documento: TipoDocumento
    distrito: Distrito
    estado: Estado
    oficina_registral: OficinaRegistral
}

export interface Notario {
    // columns
    s_codigo: string
    s_tipodoc: string|null
    s_numdoc: string|null
    s_paterno: string|null
    s_materno: string|null
    s_nombres: string|null
    s_cargo: string|null
    s_sexo: string|null
    s_telefonos: string|null
    s_observacion: string|null
    i_estado: number|null
    // mutators
    nombre_compuesto: string
    // relations
    tipo_documento: TipoDocumento
}

export interface UserClientExternal {
    // columns
    s_codigo: string
    s_paterno: string|null
    s_materno: string|null
    s_nombres: string|null
    s_tipo_docu: string|null
    s_num_doc: string|null
    d_fecha_nac: string|null
    s_estado_civil: string|null
    s_nacionalidad: string|null
    s_localidad: string|null
    s_direccion: string|null
    s_referencia: string|null
    s_sexo: string|null
    s_correo: string|null
    s_telefono: string|null
    s_celular: string|null
    s_pass?: unknown|null
    s_profesion: string|null
    s_otro_profesion: string|null
    s_cargo: string|null
    s_otro_cargo: string|null
    i_residencia: number|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    nombre_compuesto: string
    // relations
    notifications: DatabaseNotification[]
    tokens: PersonalAccessToken[]
}

export interface UserCompanyExternal {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_tip_doc: string|null
    s_num_doc: string|null
    i_nacionalidad: number|null
    s_localidad: string|null
    s_direccion: string|null
    s_referencia: string|null
    s_email: string|null
    s_web: string|null
    s_telefono: string|null
    s_celular: string|null
    s_oficina: string|null
    s_partida: string|null
    s_registro: string|null
    s_ciiu: string|null
    s_objeto_social: string|null
    s_anotacion: string|null
    s_pass?: unknown|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    nombre_compuesto: string
    // relations
    tokens: PersonalAccessToken[]
}

export interface PermisoViajeExternal {
    // columns
    id: number
    id_user_register: string|null
    travel: string
    date_ret: string|null
    date_sal: string|null
    return: number|null
    type: number|null
    format: number|null
    line: unknown|null
    obervation: string|null
    route: string
    transport: number
    read: boolean|null
    id_user_read: string|null
    date_read: string|null
    phone: string|null
    email: string|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // mutators
    tipo_viaje: string
    tipo_transporte: string
    // relations
    participantes: PermisoViajeParticipantExternal[]
    usuario_cliente: UserClientExternal
    usuario_empresa: UserCompanyExternal
}

export interface PermisoViajeParticipantExternal {
    // columns
    id: number
    id_permiso_viaje: number
    type_doc: string|null
    num_doc: string|null
    name: string
    paternal: string|null
    maternal: string|null
    birthday: string|null
    age: string|null
    type: number|null
    sex: string|null
    status_civil: string|null
    nationality: string|null
    locality: string|null
    address: string|null
    with_signature: boolean|null
    email: string|null
    num_partida: string|null
    sede_registral: string|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // mutators
    nombre_compuesto: string
    rol: string
    // relations
    files: PermisoViajeDocument[]
}

export interface ClientExternal {
    // columns
    id: number
    tipo_documento: string
    documento: string
    nombres: string
    paterno: string
    materno: string|null
    kardex: string|null
    cod_personal: string
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    cod_auth: string|null
    testimonio_digital_file: string|null
    // mutators
    is_date_mayor: unknown
    nombre_compuesto: string
}

export interface TramiteKardexExternalDocument {
    // columns
    id: number
    id_kardex: number|null
    file: unknown
    tipo_archivo: string
    name: unknown
    type: string|null
    size: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    personal: string|null
    cod_personal: string|null
    estado_clic: boolean
    // mutators
    server_id: number
    filepond: string[]
    options: string[]
    source: string
    // relations
    cliente_external: ClientExternal
}

export interface Carta {
    // columns
    s_carta: string
    s_codigo: string
    s_numcarta: number|null
    s_acto_notarial: string|null
    s_servicio: string|null
    s_remitente: string|null
    s_empresa: string|null
    s_facturado: string|null
    d_fecha: string|null
    s_hora: string|null
    d_fecha_cierre: string|null
    s_destinatario: string|null
    s_localidad: string|null
    s_direccioncarta: string|null
    s_atendido: string|null
    d_fecha_entrega: string|null
    s_hora_entrega: string|null
    s__n1: string|null
    s__n2: string|null
    s__n3: string|null
    s__n4: string|null
    s_descripcion: string|null
    s_observacion: string|null
    s_entregado: string|null
    s_mensajero: string|null
    s_recogido: string|null
    d_fecha_regogido: string|null
    i_cantidad: number|null
    de_precio: number|null
    s_hora_recogido: string|null
    i_tipopago: number|null
    i_estado: number|null
    // relations
    remitente_cliente: Cliente[]
    referente_cliente: Cliente[]
    remitente_empresa: Empresa[]
    empresa_empresa: Empresa[]
    facturado_empresa: Empresa[]
    facturado_cliente: Cliente[]
}

export interface CartaOrden {
    // columns
    s_codigo: string
}

export interface CopiaCertificada {
    // columns
    s_codigo: string
    i_copias: number|null
    i_inicial: number|null
    s_descripcion: string|null
    s_pertenece: string|null
    s_libros: string|null
    s_consta: string|null
    s_folios: string|null
    s_cargo: string|null
    s_legalizado: string|null
    d_fecha_legalizado: string|null
    s_numero_reg: string|null
    d_fecha: string|null
    s_hora: string|null
    s_observacion: string|null
    s_atendido: string|null
    i_estado: number|null
    // mutators
    fecha_legalizado: string
}

export interface DetalleRecibo {
    // columns
    s_codigo: string
    s_recibo: string|null
    s_referencia: string|null
    s_servicio: string|null
    s_detalle: string|null
    de_precio: number|null
    i_cantidad: number|null
    de_sub_total: number|null
    de_igv: number|null
    de_total: number|null
    i_estado: number|null
}

export interface DiligenciaCarta {
    // columns
    i_codigo: number
    s_num_carta: number|null
    d_fecha_entrega: string|null
    s_recibido_por: string|null
    s_recibido_dni: string|null
    s_relacion_destinatario: string|null
    s_pisos: string|null
    s_color: string|null
    s_puertas: string|null
    s_ventanas: string|null
    s_proyeccion: string|null
    s_observacion: string|null
    s_diligenciado: string|null
    i_estado: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    inmueble: string
}

export interface DiligenciaFoto {
    // columns
    i_codigo: number
    i_diligencia_carta: number|null
    s_foto: string
    s_name: unknown
    s_type: string|null
    i_size: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
}

export interface DiligenciaProgramada {
    // columns
    i_codigo: number
    d_fecha_programacion: string|null
    s_num_carta: number|null
    s_observacion: string|null
    s_motorizado: string|null
    s_personal_reg: string|null
    i_estado: boolean|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // relations
    cartas: Cartum[]
    diligencia_carta: DiligenciaCartum
    motorizado: User
}

export interface Firma {
    // columns
    s_codigo: string
    s_cliente: string|null
    d_fecha_registro: string|null
    s_proceder: string|null
    d_caducidad: string|null
    s_atendido: string|null
    s_observacion: string|null
    i_estado: number|null
    foto_firma: string|null
    // relations
    cliente: Cliente
    atendido: User
    files: FirmaDocument[]
}

export interface FirmaDocument {
    // columns
    id: number
    id_firma: string
    file: string
    name: unknown
    type: string|null
    size: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // mutators
    server_id: number
    filepond: string[]
    options: string[]
    source: string
}

export interface FirmaRepresentacion {
    // columns
    s_codigo: string
    s_representado: string|null
    s_cliente: string|null
    s_observacion: string|null
    i_estado: number|null
    // relations
    cliente: Empresa
}

export interface Libro {
    // columns
    s_libro: number
    s_codigo: string|null
    s_actonotarial: string|null
    s_registro: number|null
    d_fecha_apertura: string|null
    s_hora_apertura: string|null
    d_fecha_cierre: string|null
    s_observacion: string|null
    s_tipolibro: string|null
    s_denominacion: string|null
    s_numero_libro: string|null
    s_forma: string|null
    s_folios: string|null
    s_cantidad: number|null
    s_precio: number|null
    i_tipopago: number|null
    s_cliente: string|null
    s_empresa: string|null
    s_facturar: string|null
    s_representante: string|null
    s_atendido: string|null
    s_personal_entrega: string|null
    s_hora_entrega: string|null
    d_fecha_entrega: string|null
    s_entregado: string|null
    i_imprime: number|null
    i_sisgen: string|null
    i_estado: number|null
    // mutators
    solicitante: unknown
    imprime: string
    // relations
    empresa: Empresa
    facturado: Empresa
    representante: Cliente
    files: LibroDocument[]
}

export interface LibroDocument {
    // columns
    id: number
    id_libro: string
    file: string
    name: unknown
    type: string|null
    size: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // mutators
    server_id: number
    filepond: string[]
    options: string[]
    source: string
}

export interface LibroOrden {
    // columns
    s_codigo: string
}

export interface OficinaRegistral {
    // columns
    s_codigo: string
    s_codigo_sbs: string|null
    s_nombre: string|null
    i_estado: number|null
}

export interface OrdenCaja {
    // columns
    s_codigo: string
    s_referencia: string|null
    d_fecha: string|null
    s_hora: string|null
    i_estado: number|null
}

export interface Pago {
    // columns
    s_codigo: string
    s_recibo: string|null
    d_fecha: string|null
    s_medio_pago: string|null
    s_detalle: string|null
    s_banco: string|null
    d_fecha_ope: string|null
    s_numero: string|null
    s_moneda: string|null
    s_tipocambio: string|null
    de_importe: number|null
    de_cobre: number|null
    d_fecha_cheque: string|null
    s_deposito: string|null
    i_estado: number|null
}

export interface Participante {
    // columns
    i_codigo: number
    i_permiso: number|null
    i_condicion: number|null
    s_participante: string|null
    i_firma: number|null
    s_edad: string|null
    s_partida: string|null
    s_sede_reg: string|null
    s_observacion: string|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    participa_como: string
    // relations
    tipo_documento: TipoDocumento
    oficina_registral: OficinaRegistral
    condicion: Condicion
    cliente: Cliente
}

export interface PermisoViaje {
    // columns
    i_codigo: number
    d_fecha_ins: string|null
    i_numero: number|null
    i_tipo: number|null
    d_fecha_sal: string|null
    d_fecha_ret: string|null
    s_transporte: string|null
    s_linea: string|null
    s_ruta: string|null
    i_retorno: number|null
    s_observacion: string|null
    s_hijo: string|null
    s_edad: string|null
    i_solo: number|null
    s_formato: string|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    i_estado: number|null
    // mutators
    tipo_viaje: string
    tipo_transporte: string
    solo_acompanado: string
    retorno: string
    formato: string
    // relations
    participantes: Participante[]
    usuario: User
    acompanantes: Participante[]
    files: PermisoViajeDocument[]
}

export interface PermisoViajeDocument {
    // columns
    id: number
    id_permiso_viaje: number
    id_participant: number|null
    file: string
    name: unknown
    type: string|null
    size: number|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // mutators
    server_id: number
    filepond: string[]
    options: string[]
    source: string
}

export interface ReciboPago {
    // columns
    s_codigo: string
    s_facturado: string|null
    s__atendido: string|null
    s_caja: string|null
    s_anulado: string|null
    s_autorizado: string|null
    s_razon: string|null
    d_anulacion: string|null
    s_tipo_documento: string|null
    s_numero_serie: string|null
    d_fecha: string|null
    s_hora: string|null
    s_tipo: string|null
    de_sub_total: number|null
    de_igv: number|null
    de_total: number|null
    de_pagado: number|null
    de_cobre: number|null
    d_fecha_vencimiento: string|null
    s_observacion: string|null
    s_doc_modifica_tipo: string|null
    s_doc_modifica_serie: string|null
    s_doc_modifica_numero: string|null
    s_tipo_nota_credito: string|null
    s_codigo_hash: string|null
    s_enviado: string|null
    s_documento: string|null
    i_pago_credito: number|null
    s_orden_compra_servicio: string|null
    i_estado: number|null
}

export interface Arancel {
    // columns
    s_codigo: string
    s_servicio: string|null
    s_tipo: string|null
    s_rango: string|null
    de_precio: number|null
}

export interface AsignacionLaboral {
    // columns
    s_codigo: string
    s_personal: string|null
    s_cargo: string|null
    s_area: string|null
    s_seccion: string|null
    d_fecha_ing: string|null
    d_fecha_fin: string|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    i_estado: number|null
}

export interface BancoDeposito {
    // columns
    i_codigo: number
    s_nombre: string|null
    s_contable: string|null
    s_descripcion: string|null
    s_tipo: string|null
    i_estado: number|null
}

export interface Cargo {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_descripcion: string|null
    i_estado: number|null
    // mutators
    descripcion: string
}

export interface CargoPublico {
    // columns
    código: string
    descripción: string|null
    i_estado: number
    // mutators
    descripcion: string
}

export interface Condicion {
    // columns
    id: number
    nombre: string|null
    id_cnl: string|null
    estado: number|null
}

export interface Departamento {
    // columns
    s_codigo: string
    s_departamento: unknown|null
}

export interface DetalleRango {
    // columns
    s_codigo: string
    s_servicios: string|null
    s_colum1: string|null
    s_colum2: string|null
    de_precio: number|null
}

export interface Distrito {
    // columns
    s_codigo: string
    s_distrito: string|null
    // mutators
    distrito: string
    ubigeo_compuesto: string
    provincia: string
    departamento: string
}

export interface DocumentoVenta {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_abrev: string|null
    s_serie: string|null
    s_impresora: string|null
    i_tipo_comprobante_fe: number|null
    i_estado: number|null
    // mutators
    id_tipo_comprobante: unknown
}

export interface Estado {
    // columns
    i_codigo: number
    s_codigo_sbs: string|null
    s_tipo: number|null
    s_desc: string|null
    i_estado: number|null
}

export interface ModoPago {
    // columns
    i_codigo: number
    s_codigo_pdt: string
    s_codigo_sbs: string|null
    s_nombre: string|null
    s_descripcion: string|null
    i_estado: number|null
}

export interface Nacionalidad {
    // columns
    s_codigo: string
    s_pais: string|null
    s_gentilicio: string|null
    s_codigo_sbs: string|null
    i_estado: number|null
}

export interface Pais {
    // columns
    s_codigo: string
    s_pais: unknown|null
    s_gentilicio_m: unknown|null
    s_gentilicio_f: unknown|null
    i_estado: number|null
    // mutators
    spais: unknown
    sgentiliciom: unknown
    sgentiliciof: unknown
}

export interface Permission {
    // columns
    id: number
    name: string
    guard_name: string
    created_at: string|null
    updated_at: string|null
}

export interface Provincia {
    // columns
    s_codigo: string
    s_provincia: unknown|null
}

export interface Requisito {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_descripcion: string|null
    i_estado: number|null
}

export interface Role {
    // columns
    id: number
    name: string
    guard_name: string
    created_at: string|null
    updated_at: string|null
}

export interface Servicio {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_descripcion: string|null
    s_generico: string|null
    i_formato: number|null
    i_rapidos: number|null
    i_estado: number|null
}

export interface Situacion {
    // columns
    i_codigo: number
    s_tipo: string
    s_nombre: string
    i_estado: number
}

export interface TipoCompareciente {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_codigo_sg: string|null
    s_tipo_pdt: string|null
    s_color: string|null
    s_clase: string|null
    i_estado: number|null
}

export interface TipoDocumento {
    // columns
    s_codigo: string
    s_codigo_sbs: string|null
    s_cod_cnl: string|null
    s_nombre: string|null
    s_abrev: string|null
    i_digitos: unknown|null
    s_tipo_fe: string|null
    i_estado: number|null
}

export interface Unidad {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_abrev: string|null
    s_observacion: string|null
    i_estado: number|null
}

export interface ZonaRegistral {
    // columns
    s_codigo: string
    s_codigo_sbs: string|null
    s_nombre: string|null
    i_estado: number|null
}

export interface PersonalAccessToken {
    // columns
    id: number
    tokenable_type: string
    tokenable_id: string
    name: string
    token?: string
    abilities: string|null
    last_used_at: string|null
    expires_at: string|null
    created_at: string|null
    updated_at: string|null
}

export interface DetallePresencia {
    // columns
    s_codigo: string
    s_referencia: string|null
    s_actonotarial: string|null
    s_descripcion: string|null
    s_hora_inicio: string|null
    s_hora_fin: string|null
    d_fechapresen: string|null
    s_lugar: string|null
    s_asitente: string|null
    s_observacion: string|null
    i_cantidad: number|null
    de_precio: number|null
    i_estado: number|null
    // relations
    asistente: User
}

export interface DetalleProcurador {
    // columns
    id: number
    s_presencia: string|null
    s_procurador: string|null
    s_date_inicio: string|null
    s_date_fin: string|null
    s_anotacion: string|null
    i_estado: boolean
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // relations
    documentos_init: DetalleProcuradorDocument[]
    documentos_finish: DetalleProcuradorDocument[]
}

export interface DetalleProcuradorDocument {
    // columns
    id: number
    id_detalle_procurador: number|null
    s_personal: string|null
    file: string|null
    name: string
    type: string|null
    size: number|null
    i_estado: boolean
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    tipo_doc: string|null
    // relations
    personal: User
}

export interface HistorialTramite {
    // columns
    id: number
    s_tramite: string|null
    i_tipo: number|null
    s_personal: string|null
    s_observacion: string|null
    created_at: string|null
    updated_at: string|null
    deleted_at: string|null
    // relations
    personal: User
    cliente: Cliente
    empresa: Empresa
}

export interface Interviniente {
    // columns
    s_codigo: string
    s_kardex: string|null
    i_grupo: number|null
    i_item: number|null
    s_compareciente: string|null
    s_proceder: string|null
    s_tipo: string|null
    d_fecha: string|null
    s_hora: string|null
    s_personal: string|null
    i_indice: number|null
    i_pdt: number|null
    i_foto: number|null
    i_firma: number|null
    d_fechfirma: string|null
    s_hora_firma: string|null
    s_tomador: string|null
    i_lugar_firma: number|null
    s_lugar_firma: string|null
    s_rol_participacion: string|null
    s_casado: string|null
    i_separacion_bienes: number|null
    s_oficina_reg: string|null
    s_registro: string|null
    s_partida: string|null
    i_inscrito: number|null
    s_representa: string|null
    s_oficina_rep: string|null
    s_registro_rep: string|null
    s_partida_rep: string|null
    s_porcentaje: string|null
    s_origen_fondo: string|null
    s_moneda: string|null
    de_monto: number|null
    s_renta_terc: string|null
    s_casa_enaj: string|null
    s_imp_cero: string|null
    s_ope_1662: string|null
    s_pago_2cat: string|null
    s_operacion: string|null
    i_prico: number|null
    i_estado: number|null
    // mutators
    compareciente: unknown
}

export interface Kardex {
    // columns
    s_codigo: string
    s_tipokardex: string|null
    s_kardex: number|null
    s_actnot: string|null
    s_compareciente: string|null
    s_referente: string|null
    s_facturar: string|null
    d_feching: string|null
    s_horaing: string|null
    s_atendido: string|null
    s_responsable: string|null
    s_digitado: string|null
    d_fecha_digitado: string|null
    s_impreso: string|null
    d_fecha_impreso: string|null
    s_confrontador: string|null
    s_confrontador_seg: string|null
    d_fecha_confrontado: string|null
    d_fechcalificada: string|null
    d_fechminuta: string|null
    i_numminuta: string|null
    i_minuta_usuario: number|null
    d_fechescritura: string|null
    i_numescritura: number|null
    s_opcion_escritura: string|null
    d_fechparte: string|null
    s_personal_parte: string|null
    d_fechtestimonio: string|null
    s_personal_testimonio: string|null
    s_kardexconex: string|null
    s_abogado: string|null
    s_personal_abogado: string|null
    d_fecha_abogado: string|null
    s_anno: string|null
    i_numfol: number|null
    i_folini: number|null
    i_folini_v: number|null
    i_folfin: number|null
    i_folfin_v: number|null
    i_serini: number|null
    i_serieini_v: number|null
    i_serfin: number|null
    i_seriefin_v: number|null
    s_numtom: string|null
    s_numreg: string|null
    i_numero_operacion: string|null
    s_obstitulo: string|null
    s_tipo_tramite: string|null
    s_num_solicitud: string|null
    d_fecha_solicitud: string|null
    i_estadonota: string|null
    d_fechbajakardex: string|null
    s_personal_baja: string|null
    i_sisgen: number|null
    i_estado: number|null
    // mutators
    num_kardex: number
    // relations
    cliente: Cliente
    empresa: Empresa
    asesor: User
    estado: Estado
}

export interface Presencia {
    // columns
    s_codigo: string
    s_contacto: string|null
    s_referente: string|null
    s_facturado: string|null
    d_fecha_registro: string|null
    s_hora_registro: string|null
    s_atendido: string|null
    i_tipopago: number|null
    s_observacion: string|null
    i_estado: number|null
    // relations
    contacto_cliente: Cliente
    contacto_empresa: Empresa
    facturado_cliente: Cliente
    facturado_empresa: Empresa
    referente_cliente: Cliente
    referente_empresa: Empresa
    atendido: User
    detalle: DetallePresencium[]
    detalle_procurador: DetalleProcurador
}

export interface RegistroPublico {
    // columns
    s_codigo: string
    s_kardex: string|null
    s_titulo: string|null
    d_fecha: string|null
    s_hora: string|null
    s_area: string|null
    s_oficina: string|null
    s_estado_r: string|null
    de_pagado: number|null
    s_partida: string|null
    s_asiento: string|null
    s_orden: string|null
    s_tipo_pago: string|null
    d_fecha_plazo: string|null
    s_descargo: string|null
    s_tive: string|null
    s_personal_registro: string|null
    d_fecha_registro: string|null
    s_usuario_modificacion: string|null
    d_fecha_modificacion: string|null
    i_estado: number|null
}

export interface ServicioNotarial {
    // columns
    s_codigo: string
    s_kardex: string|null
    s_tipo_servicio: number|null
    s_servicio: string|null
    i_cantidad: number|null
    de_precio: number|null
    de_total: number|null
    i_estado: number|null
}

export interface TipoKardex {
    // columns
    s_codigo: string
    s_nombre: string|null
    s_abre: string|null
    s_descripcion: string|null
    s_clase: string|null
    i_estado: number|null
}

export interface User {
    // columns
    s_codigo: string
    s_paterno: string|null
    s_materno: string|null
    s_nombres: string|null
    s_nombre_seg: string|null
    s_tipo_docu: string|null
    s_numero: string|null
    s_estado_civil: string|null
    d_fecha_nacimiento: string|null
    s_sexo: string|null
    s_nacionalidad: string|null
    s_distrito: string|null
    s_direccion: string|null
    s_mail: string|null
    s_telefono: string|null
    s_celular: string|null
    s_correo_tra: string|null
    s_telefono_tra: string|null
    s_celular_tra: string|null
    s_anexo_tra: string|null
    s_observacion: string|null
    s_barra: string|null
    s_user: string|null
    s_pass?: string|null
    d_fecha_reg: string|null
    s_personal_reg: string|null
    d_fecha_mod: string|null
    s_personal_mod: string|null
    deleted_at: string|null
    i_estado: number|null
    // mutators
    estado_civil: string
    nombre_compuesto: string
    id_tipo_documento: string
    // relations
    ubigeo: Distrito
    nacionalidad: Nacionalidad
    tipo_documento: TipoDocumento
    asignacion_laboral: AsignacionLaboral[]
    tokens: PersonalAccessToken[]
    roles: Role[]
    permissions: Permission[]
}
