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
];

export default routerProtocolar;
