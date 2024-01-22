import {configProtocolar as Config} from "./ProtocolarConfig"


const routerProtocolar = [
    {
        ...Config._TRAMITE_.listar,
        component: () =>
            import(
                `../../pages/${Config._TRAMITE_.folder}/${Config._TRAMITE_.page}/${Config._TRAMITE_.listar.file}.vue`
                ),
        children: [
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
        ],
    },
];

export default routerProtocolar;
