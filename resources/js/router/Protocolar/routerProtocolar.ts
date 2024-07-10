import {configProtocolar as Config} from "./ProtocolarConfig";

const routerProtocolar = [
    {
        ...Config._TRAMITE_.listar,
        component: () =>
            import(
                `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._TRAMITE_.detalle,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.detalle.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                    noLayout: true,
                },
            },
        ]
    },
    {
        ...Config._TRAMITE_.add,
        props: true,
        component: () =>
            import(
                `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.add.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },

    },
    {
        ...Config._TRAMITE_.update,
        path: '/tramite/update/:id',
        props: true,
        component: () =>
            import(
                `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.update.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
        },
    },

    {
        ...Config._TRAMITE_.detalleSK,
        path: '/tramite/view/doc/:id',
        props: true,
        component: () =>
            import(
                `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.detalleSK.file}.vue`
                ),
        meta: {
            showModal: true,
            persistent: true,
            noLayout: true,
        },
    },
    {
        ...Config._PRESENCIA_NOTARIALES_.listar,
        component: () =>
            import(
                `../../pages/${Config._PRESENCIA_NOTARIALES_.folder}/${Config._PRESENCIA_NOTARIALES_.page}/${Config._PRESENCIA_NOTARIALES_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._PRESENCIA_NOTARIALES_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PRESENCIA_NOTARIALES_.folder}/${Config._PRESENCIA_NOTARIALES_.page}/${Config._PRESENCIA_NOTARIALES_.add.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                    noLayout: true,
                },
            },
            {
                ...Config._PRESENCIA_NOTARIALES_.detail,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PRESENCIA_NOTARIALES_.folder}/${Config._PRESENCIA_NOTARIALES_.page}/${Config._PRESENCIA_NOTARIALES_.detail.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                    noLayout: true,
                },
            },
            {
                ...Config._PRESENCIA_NOTARIALES_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PRESENCIA_NOTARIALES_.folder}/${Config._PRESENCIA_NOTARIALES_.page}/${Config._PRESENCIA_NOTARIALES_.update.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                    noLayout: true,
                },
            },
        ]
    },
    {
        ...Config._PROCURADORES_.listar,
        component: () =>
            import(
                `../../pages/${Config._PROCURADORES_.folder}/${Config._PROCURADORES_.page}/${Config._PROCURADORES_.listar.file}.vue`
                ),
        children: [
            {
                ...Config._PROCURADORES_.detail,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PROCURADORES_.folder}/${Config._PROCURADORES_.page}/${Config._PROCURADORES_.detail.file}.vue`
                        ),
                meta: {
                    showModal: true,
                    persistent: true,
                    noLayout: true,
                },
            },
        ]
    },

];

export default routerProtocolar;
