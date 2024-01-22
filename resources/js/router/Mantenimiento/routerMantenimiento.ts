import { configMantenimiento as Config } from "./MantenimientoConfig";

const routerMantenimiento = [
    {
        ...Config._CONDICION_.listar,
        component: () =>
            import(
                `../../pages/${Config._CONDICION_.folder}/${Config._CONDICION_.page}/${Config._CONDICION_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._CONDICION_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CONDICION_.folder}/${Config._CONDICION_.page}/${Config._CONDICION_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CONDICION_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CONDICION_.folder}/${Config._CONDICION_.page}/${Config._CONDICION_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._TIPO_DOCUMENTO_.listar,
        component: () =>
            import(
                `../../pages/${Config._TIPO_DOCUMENTO_.folder}/${Config._TIPO_DOCUMENTO_.page}/${Config._TIPO_DOCUMENTO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._TIPO_DOCUMENTO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPO_DOCUMENTO_.folder}/${Config._TIPO_DOCUMENTO_.page}/${Config._TIPO_DOCUMENTO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._TIPO_DOCUMENTO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPO_DOCUMENTO_.folder}/${Config._TIPO_DOCUMENTO_.page}/${Config._TIPO_DOCUMENTO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._UBIGEO_.listar,
        component: () =>
            import(
                `../../pages/${Config._UBIGEO_.folder}/${Config._UBIGEO_.page}/${Config._UBIGEO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._UBIGEO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._UBIGEO_.folder}/${Config._UBIGEO_.page}/${Config._UBIGEO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._UBIGEO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._UBIGEO_.folder}/${Config._UBIGEO_.page}/${Config._UBIGEO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._UNIDADES_.listar,
        component: () =>
            import(
                `../../pages/${Config._UNIDADES_.folder}/${Config._UNIDADES_.page}/${Config._UNIDADES_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._UNIDADES_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._UNIDADES_.folder}/${Config._UNIDADES_.page}/${Config._UNIDADES_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._UNIDADES_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._UNIDADES_.folder}/${Config._UNIDADES_.page}/${Config._UNIDADES_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._BANCO_DEPOSITO_.listar,
        component: () =>
            import(
                `../../pages/${Config._BANCO_DEPOSITO_.folder}/${Config._BANCO_DEPOSITO_.page}/${Config._BANCO_DEPOSITO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._BANCO_DEPOSITO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BANCO_DEPOSITO_.folder}/${Config._BANCO_DEPOSITO_.page}/${Config._BANCO_DEPOSITO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._BANCO_DEPOSITO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BANCO_DEPOSITO_.folder}/${Config._BANCO_DEPOSITO_.page}/${Config._BANCO_DEPOSITO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },


    {
        ...Config._SERVICIO_.listar,
        component: () =>
            import(
                `../../pages/${Config._SERVICIO_.folder}/${Config._SERVICIO_.page}/${Config._SERVICIO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._SERVICIO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._SERVICIO_.folder}/${Config._SERVICIO_.page}/${Config._SERVICIO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._SERVICIO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._SERVICIO_.folder}/${Config._SERVICIO_.page}/${Config._SERVICIO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },

    {
        ...Config._TIPO_COMPARECIENTE_.listar,
        component: () =>
            import(
                `../../pages/${Config._TIPO_COMPARECIENTE_.folder}/${Config._TIPO_COMPARECIENTE_.page}/${Config._TIPO_COMPARECIENTE_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._TIPO_COMPARECIENTE_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPO_COMPARECIENTE_.folder}/${Config._TIPO_COMPARECIENTE_.page}/${Config._TIPO_COMPARECIENTE_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._TIPO_COMPARECIENTE_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPO_COMPARECIENTE_.folder}/${Config._TIPO_COMPARECIENTE_.page}/${Config._TIPO_COMPARECIENTE_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._NACIONALIDAD_.listar,
        component: () =>
            import(
                `../../pages/${Config._NACIONALIDAD_.folder}/${Config._NACIONALIDAD_.page}/${Config._NACIONALIDAD_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._NACIONALIDAD_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._NACIONALIDAD_.folder}/${Config._NACIONALIDAD_.page}/${Config._NACIONALIDAD_.add.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
            {
                ...Config._NACIONALIDAD_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._NACIONALIDAD_.folder}/${Config._NACIONALIDAD_.page}/${Config._NACIONALIDAD_.update.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
        ],
    },
    {
        ...Config._REQUISITO_.listar,
        component: () =>
            import(
                `../../pages/${Config._REQUISITO_.folder}/${Config._REQUISITO_.page}/${Config._REQUISITO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._REQUISITO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REQUISITO_.folder}/${Config._REQUISITO_.page}/${Config._REQUISITO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._REQUISITO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REQUISITO_.folder}/${Config._REQUISITO_.page}/${Config._REQUISITO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._PAIS_.listar,
        component: () =>
            import(
                `../../pages/${Config._PAIS_.folder}/${Config._PAIS_.page}/${Config._PAIS_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._PAIS_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PAIS_.folder}/${Config._PAIS_.page}/${Config._PAIS_.add.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
            {
                ...Config._PAIS_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PAIS_.folder}/${Config._PAIS_.page}/${Config._PAIS_.update.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
        ],
    },

    {
        ...Config._MODO_PAGO_.listar,
        component: () =>
            import(
                `../../pages/${Config._MODO_PAGO_.folder}/${Config._MODO_PAGO_.page}/${Config._MODO_PAGO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._MODO_PAGO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._MODO_PAGO_.folder}/${Config._MODO_PAGO_.page}/${Config._MODO_PAGO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._MODO_PAGO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._MODO_PAGO_.folder}/${Config._MODO_PAGO_.page}/${Config._MODO_PAGO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._DOCUMENTO_VENTA_.listar,
        component: () =>
            import(
                `../../pages/${Config._DOCUMENTO_VENTA_.folder}/${Config._DOCUMENTO_VENTA_.page}/${Config._DOCUMENTO_VENTA_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._DOCUMENTO_VENTA_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._DOCUMENTO_VENTA_.folder}/${Config._DOCUMENTO_VENTA_.page}/${Config._DOCUMENTO_VENTA_.add.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
            {
                ...Config._DOCUMENTO_VENTA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._DOCUMENTO_VENTA_.folder}/${Config._DOCUMENTO_VENTA_.page}/${Config._DOCUMENTO_VENTA_.update.file}.vue`
                    ),
                    meta: {
                        showModal: true,
                        persistent: true,
                    },
            },
        ],
    },
    {
        ...Config._CARGO_PUBLICO_.listar,
        component: () =>
            import(
                `../../pages/${Config._CARGO_PUBLICO_.folder}/${Config._CARGO_PUBLICO_.page}/${Config._CARGO_PUBLICO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._CARGO_PUBLICO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARGO_PUBLICO_.folder}/${Config._CARGO_PUBLICO_.page}/${Config._CARGO_PUBLICO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CARGO_PUBLICO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARGO_PUBLICO_.folder}/${Config._CARGO_PUBLICO_.page}/${Config._CARGO_PUBLICO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._ZONA_REGISTRAL_.listar,
        component: () =>
            import(
                `../../pages/${Config._ZONA_REGISTRAL_.folder}/${Config._ZONA_REGISTRAL_.page}/${Config._ZONA_REGISTRAL_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._ZONA_REGISTRAL_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ZONA_REGISTRAL_.folder}/${Config._ZONA_REGISTRAL_.page}/${Config._ZONA_REGISTRAL_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._ZONA_REGISTRAL_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ZONA_REGISTRAL_.folder}/${Config._ZONA_REGISTRAL_.page}/${Config._ZONA_REGISTRAL_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._CARGO_.listar,
        component: () =>
            import(
                `../../pages/${Config._CARGO_.folder}/${Config._CARGO_.page}/${Config._CARGO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._CARGO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARGO_.folder}/${Config._CARGO_.page}/${Config._CARGO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CARGO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARGO_.folder}/${Config._CARGO_.page}/${Config._CARGO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._ESTADO_.listar,
        component: () =>
            import(
                `../../pages/${Config._ESTADO_.folder}/${Config._ESTADO_.page}/${Config._ESTADO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._ESTADO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ESTADO_.folder}/${Config._ESTADO_.page}/${Config._ESTADO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._ESTADO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ESTADO_.folder}/${Config._ESTADO_.page}/${Config._ESTADO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
];

export default routerMantenimiento;
