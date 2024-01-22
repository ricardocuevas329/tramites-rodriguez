import { configEntidad as Config } from "./EntidadConfig";

const routerEntidad = [
    {
        ...Config._PERSONAL_.listar,
        component: () =>
            import(
                `../../pages/${Config._PERSONAL_.folder}/${Config._PERSONAL_.page}/${Config._PERSONAL_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._PERSONAL_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PERSONAL_.folder}/${Config._PERSONAL_.page}/${Config._PERSONAL_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._PERSONAL_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._PERSONAL_.folder}/${Config._PERSONAL_.page}/${Config._PERSONAL_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._CLIENTE_.listar,
        component: () =>
            import(
                `../../pages/${Config._CLIENTE_.folder}/${Config._CLIENTE_.page}/${Config._CLIENTE_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._CLIENTE_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CLIENTE_.folder}/${Config._CLIENTE_.page}/${Config._CLIENTE_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._CLIENTE_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._CLIENTE_.folder}/${Config._CLIENTE_.page}/${Config._CLIENTE_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },

    {
        ...Config._EMPRESA_.listar,
        component: () =>
            import(
                `../../pages/${Config._EMPRESA_.folder}/${Config._EMPRESA_.page}/${Config._EMPRESA_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._EMPRESA_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._EMPRESA_.folder}/${Config._EMPRESA_.page}/${Config._EMPRESA_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._EMPRESA_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._EMPRESA_.folder}/${Config._EMPRESA_.page}/${Config._EMPRESA_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._ABOGADO_.listar,
        component: () =>
            import(
                `../../pages/${Config._ABOGADO_.folder}/${Config._ABOGADO_.page}/${Config._ABOGADO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._ABOGADO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ABOGADO_.folder}/${Config._ABOGADO_.page}/${Config._ABOGADO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._ABOGADO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._ABOGADO_.folder}/${Config._ABOGADO_.page}/${Config._ABOGADO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._NOTARIO_.listar,
        component: () =>
            import(
                `../../pages/${Config._NOTARIO_.folder}/${Config._NOTARIO_.page}/${Config._NOTARIO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._NOTARIO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._NOTARIO_.folder}/${Config._NOTARIO_.page}/${Config._NOTARIO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._NOTARIO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._NOTARIO_.folder}/${Config._NOTARIO_.page}/${Config._NOTARIO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
    {
        ...Config._COMPARECIENTE_BLOQUEADO_.listar,
        component: () =>
            import(
                `../../pages/${Config._COMPARECIENTE_BLOQUEADO_.folder}/${Config._COMPARECIENTE_BLOQUEADO_.page}/${Config._COMPARECIENTE_BLOQUEADO_.listar.file}.vue`
            ),
        children: [
            {
                ...Config._COMPARECIENTE_BLOQUEADO_.add,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._COMPARECIENTE_BLOQUEADO_.folder}/${Config._COMPARECIENTE_BLOQUEADO_.page}/${Config._COMPARECIENTE_BLOQUEADO_.add.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
            {
                ...Config._COMPARECIENTE_BLOQUEADO_.update,
                props: true,
                component: () =>
                    import(
                        `../../pages/${Config._COMPARECIENTE_BLOQUEADO_.folder}/${Config._COMPARECIENTE_BLOQUEADO_.page}/${Config._COMPARECIENTE_BLOQUEADO_.update.file}.vue`
                    ),
                meta: {
                    showModal: true,
                    persistent: true,
                },
            },
        ],
    },
];

export default routerEntidad;
