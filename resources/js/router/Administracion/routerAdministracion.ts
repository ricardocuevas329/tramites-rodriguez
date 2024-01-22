import { configAdministracion as Config } from "./AdministracionConfig";

const routerAdministracion = [
    {
        ...Config._REGISTRO_VENTA_.listar,
        component: () =>
            import(
                `../../pages/${Config._REGISTRO_VENTA_.folder}/${Config._REGISTRO_VENTA_.page}/${Config._REGISTRO_VENTA_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._REGISTRO_VENTA_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REGISTRO_VENTA_.folder}/${Config._REGISTRO_VENTA_.page}/${Config._REGISTRO_VENTA_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._REGISTRO_VENTA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REGISTRO_VENTA_.folder}/${Config._REGISTRO_VENTA_.page}/${Config._REGISTRO_VENTA_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },

    {
        ...Config._REGISTRO_DEPOSITO_.listar,
        component: () =>
            import(
                `../../pages/${Config._REGISTRO_DEPOSITO_.folder}/${Config._REGISTRO_DEPOSITO_.page}/${Config._REGISTRO_DEPOSITO_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._REGISTRO_DEPOSITO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REGISTRO_DEPOSITO_.folder}/${Config._REGISTRO_DEPOSITO_.page}/${Config._REGISTRO_DEPOSITO_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._REGISTRO_DEPOSITO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._REGISTRO_DEPOSITO_.folder}/${Config._REGISTRO_DEPOSITO_.page}/${Config._REGISTRO_DEPOSITO_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._ACCION_.listar,
        component: () =>
            import(
                `../../pages/${Config._ACCION_.folder}/${Config._ACCION_.page}/${Config._ACCION_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._ACCION_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ACCION_.folder}/${Config._ACCION_.page}/${Config._ACCION_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._ACCION_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ACCION_.folder}/${Config._ACCION_.page}/${Config._ACCION_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._AREAS_.listar,
        component: () =>
            import(
                `../../pages/${Config._AREAS_.folder}/${Config._AREAS_.page}/${Config._AREAS_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._AREAS_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._AREAS_.folder}/${Config._AREAS_.page}/${Config._AREAS_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._AREAS_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._AREAS_.folder}/${Config._AREAS_.page}/${Config._AREAS_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._BANCO_.listar,
        component: () =>
            import(
                `../../pages/${Config._BANCO_.folder}/${Config._BANCO_.page}/${Config._BANCO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._BANCO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BANCO_.folder}/${Config._BANCO_.page}/${Config._BANCO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._BANCO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BANCO_.folder}/${Config._BANCO_.page}/${Config._BANCO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._BIENES_.listar,
        component: () =>
            import(
                `../../pages/${Config._BIENES_.folder}/${Config._BIENES_.page}/${Config._BIENES_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._BIENES_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BIENES_.folder}/${Config._BIENES_.page}/${Config._BIENES_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._BIENES_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._BIENES_.folder}/${Config._BIENES_.page}/${Config._BIENES_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._CONFIGURACION_.listar,
        component: () =>
            import(
                `../../pages/${Config._CONFIGURACION_.folder}/${Config._CONFIGURACION_.page}/${Config._CONFIGURACION_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._CONFIGURACION_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CONFIGURACION_.folder}/${Config._CONFIGURACION_.page}/${Config._CONFIGURACION_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CONFIGURACION_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CONFIGURACION_.folder}/${Config._CONFIGURACION_.page}/${Config._CONFIGURACION_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._PROFESION_.listar,
        component: () =>
            import(
                `../../pages/${Config._PROFESION_.folder}/${Config._PROFESION_.page}/${Config._PROFESION_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._PROFESION_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PROFESION_.folder}/${Config._PROFESION_.page}/${Config._PROFESION_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._PROFESION_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PROFESION_.folder}/${Config._PROFESION_.page}/${Config._PROFESION_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._TIPOCAMBIO_.listar,
        component: () =>
            import(
                `../../pages/${Config._TIPOCAMBIO_.folder}/${Config._TIPOCAMBIO_.page}/${Config._TIPOCAMBIO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._TIPOCAMBIO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPOCAMBIO_.folder}/${Config._TIPOCAMBIO_.page}/${Config._TIPOCAMBIO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._TIPOCAMBIO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TIPOCAMBIO_.folder}/${Config._TIPOCAMBIO_.page}/${Config._TIPOCAMBIO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
];

export default routerAdministracion;
