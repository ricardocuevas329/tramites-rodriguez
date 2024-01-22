import {configExtraProtocolar as Config} from "./ExtraProtocolarConfig";

const routerExtraProtocolar = [

    {
        ...Config._PERMISO_VIAJE_.listar,
        component: () =>
            import(
                `../../pages/${Config._PERMISO_VIAJE_.folder}/${Config._PERMISO_VIAJE_.page}/${Config._PERMISO_VIAJE_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._PERMISO_VIAJE_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PERMISO_VIAJE_.folder}/${Config._PERMISO_VIAJE_.page}/${Config._PERMISO_VIAJE_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._PERMISO_VIAJE_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PERMISO_VIAJE_.folder}/${Config._PERMISO_VIAJE_.page}/${Config._PERMISO_VIAJE_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._CARTA_.listar,
        component: () =>
            import(
                `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._CARTA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CARTA_.diligencia,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.diligencia.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CARTA_.programacion,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.programacion.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CARTA_.observation,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.observation.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._CARTA_.add,
        component: () =>
            import(
                `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.add.file}.vue`
                ),
    },
    {
        ...Config._CARTA_.new,
        component: () =>
            import(
                `../../pages/${Config._CARTA_.folder}/${Config._CARTA_.page}/${Config._CARTA_.new.file}.vue`
                ),
    },
    {
        ...Config._LIBRO_.listar,
        component: () =>
            import(
                `../../pages/${Config._LIBRO_.folder}/${Config._LIBRO_.page}/${Config._LIBRO_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._LIBRO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._LIBRO_.folder}/${Config._LIBRO_.page}/${Config._LIBRO_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._LIBRO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._LIBRO_.folder}/${Config._LIBRO_.page}/${Config._LIBRO_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._DILIGENCIA_CARTA_.listar,
        component: () =>
            import(
                `../../pages/${Config._DILIGENCIA_CARTA_.folder}/${Config._DILIGENCIA_CARTA_.page}/${Config._DILIGENCIA_CARTA_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._DILIGENCIA_CARTA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._DILIGENCIA_CARTA_.folder}/${Config._DILIGENCIA_CARTA_.page}/${Config._DILIGENCIA_CARTA_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._DILIGENCIA_CARTA_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._DILIGENCIA_CARTA_.folder}/${Config._DILIGENCIA_CARTA_.page}/${Config._DILIGENCIA_CARTA_.add.file}.vue`
                        ),
            },
            {
                ...Config._DILIGENCIA_CARTA_.view_diligencia,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._DILIGENCIA_CARTA_.folder}/${Config._DILIGENCIA_CARTA_.page}/${Config._DILIGENCIA_CARTA_.view_diligencia.file}.vue`
                        ),
            },

        ],
    },
    {
        ...Config._FIRMA_.listar,
        component: () =>
            import(
                `../../pages/${Config._FIRMA_.folder}/${Config._FIRMA_.page}/${Config._FIRMA_.listar.file}.vue`
                ),
        children: [

            {
                ...Config._FIRMA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._FIRMA_.folder}/${Config._FIRMA_.page}/${Config._FIRMA_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._FIRMA_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._FIRMA_.folder}/${Config._FIRMA_.page}/${Config._FIRMA_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],

    },

    {
        ...Config._FIRMA_.certification,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._FIRMA_.folder}/${Config._FIRMA_.page}/${Config._FIRMA_.certification.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },
    {
        ...Config._FIRMA_.report,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._FIRMA_.folder}/${Config._FIRMA_.page}/${Config._FIRMA_.report.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },
    {
        ...Config._COPIAS_CERTIFICADAS_.listar,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._COPIAS_CERTIFICADAS_.folder}/${Config._COPIAS_CERTIFICADAS_.page}/${Config._COPIAS_CERTIFICADAS_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._COPIAS_CERTIFICADAS_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._COPIAS_CERTIFICADAS_.folder}/${Config._COPIAS_CERTIFICADAS_.page}/${Config._COPIAS_CERTIFICADAS_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._COPIAS_CERTIFICADAS_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._COPIAS_CERTIFICADAS_.folder}/${Config._COPIAS_CERTIFICADAS_.page}/${Config._COPIAS_CERTIFICADAS_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },

        ],
    },
    {
        ...Config._COPIAS_CERTIFICADAS_.report,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._COPIAS_CERTIFICADAS_.folder}/${Config._COPIAS_CERTIFICADAS_.page}/${Config._COPIAS_CERTIFICADAS_.report.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },
    {
        ...Config._PRESENCIAS_NOTARIALES_.listar,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._PRESENCIAS_NOTARIALES_.folder}/${Config._PRESENCIAS_NOTARIALES_.page}/${Config._PRESENCIAS_NOTARIALES_.listar.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },
    {
        ...Config._PRESENCIAS_NOTARIALES_.report,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._PRESENCIAS_NOTARIALES_.folder}/${Config._PRESENCIAS_NOTARIALES_.page}/${Config._PRESENCIAS_NOTARIALES_.report.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },
];

export default routerExtraProtocolar;
